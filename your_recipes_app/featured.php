<?php include_once('includes/header.php'); ?>

<?php

	error_reporting(0);

    // delete selected records
    if(isset($_POST['submit'])) {

        $arr = $_POST['chk_id'];
        $count = count($arr);
        if ($count > 0) {
            foreach ($arr as $recipe_id) {

                $sql_image = "SELECT recipe_image FROM tbl_recipes WHERE recipe_id = $recipe_id";
                $img_results = mysqli_query($connect, $sql_image);

                $sql_delete = "DELETE FROM tbl_recipes WHERE recipe_id = $recipe_id";

                if (mysqli_query($connect, $sql_delete)) {
                    while ($row = mysqli_fetch_assoc($img_results)) {
                        unlink('upload/' . $row['recipe_image']);
                    }
                    $_SESSION['msg'] = "$count Selected recipes deleted";
                } else {
                    $_SESSION['msg'] = "Error deleting record";
                }

            }
        } else {
            $_SESSION['msg'] = "Whoops! no recipes selected to delete";
        }
        header("Location:featured.php");
        exit;
    } 

	if (isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>"") {
		$keyword = $_REQUEST['keyword'];
		$reload = "featured.php";
		$sql =  "SELECT n.*, c.* FROM tbl_recipes n LEFT JOIN tbl_category c ON n.cat_id = c.cid
					WHERE n.featured = '1' AND n.recipe_title LIKE '%$keyword%'
					GROUP BY n.recipe_id  
					ORDER BY n.last_update DESC";
		$result = $connect->query($sql);
	} else {
		$reload = "featured.php";
		$sql =  "SELECT n.*, c.* FROM tbl_recipes n LEFT JOIN tbl_category c ON n.cat_id = c.cid
					WHERE n.featured = '1'
					ORDER BY n.last_update DESC";
		$result = $connect->query($sql);
	}

	$rpp = $postPerPage;
	$page = intval($_GET["page"]);
	if($page <= 0) $page = 1;  
	$tcount = mysqli_num_rows($result);
	$tpages = ($tcount) ? ceil($tcount / $rpp) : 1;
	$count = 0;
	$i = ($page-1) * $rpp;
	$no_urut = ($page-1) * $rpp;	

	$now = new DateTime();
	$lastUpdate = $now->format('Y-m-d H:i:s');

    if (isset($_GET['add'])) {
    	if ($total_featured >= 10) {
			$_SESSION['msg'] = "You have reached the maximum number of featured recipes!";
			header("Location:featured.php");
			exit;
    	} else {	
    		$data = array(
				'featured' => '1',
				'last_update' => $lastUpdate
			);	
			$result = update('tbl_recipes', $data, "WHERE recipe_id = '".$_GET['add']."'");
			if ($result > 0) {
				$_SESSION['msg'] = "Success added to featured recipes";
				header("Location:featured.php");
				exit;
			}
		}
    }

    if (isset($_GET['remove'])) {
		$data = array('featured' => '0');	
		$result = update('tbl_recipes', $data, "WHERE recipe_id = '".$_GET['remove']."'");
		if ($result > 0) {
			$_SESSION['msg'] = "Removed from featured recipes";
			header("Location:featured.php");
			exit;
		}
    }

?>

<section class="content">

	<ol class="breadcrumb">
		<li><a href="dashboard.php">Dashboard</a></li>
		<li class="active">Manage Featured</a></li>
	</ol>

	<div class="container-fluid">

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card corner-radius">
					<div class="header">
						<h2>MANAGE FEATURED</h2>
						<div class="header-dropdown m-r--5">
							<a href="recipes-add.php"><button type="button" class="button button-rounded btn-offset waves-effect waves-float">ADD NEW RECIPES</button></a>
						</div>
					</div>

					<div style="margin-top: -10px;" class="body table-responsive">

						<?php if(isset($_SESSION['msg'])) { ?>
						<div class='alert alert-info alert-dismissible corner-radius bottom-offset' role='alert'>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>&nbsp;&nbsp;</button>
							<?php echo $_SESSION['msg']; ?>
						</div>
						<?php unset($_SESSION['msg']); } ?>

						<form method="get" id="form_validation">
							<table class='table'>
								<tr>
									<td>
										<div class="form-group form-float">
											<div class="form-line">
												<input type="text" class="form-control" name="keyword" placeholder="Search..." required>
											</div>
										</div>
									</td>
									<td width="1%"><a href="recipes.php"><button type="button" class="button button-rounded waves-effect waves-float">RESET</button></a></td>
									<td width="1%"><button type="submit" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">search</i></button></td>
								</tr>
							</table>
						</form>

						<?php if ($tcount == 0) { ?>
							<p align="center" style="font-size: 110%;">There are no featured recipes.</p>
						<?php } else { ?>

						<form method="post" action="">

							<table class='table table-hover table-striped table-offset'>
								<thead>
									<tr>
										<th width="35%">Recipe Name</th>
										<th width="1%">Image</th>
										<th width="15%">Time</th>
										<th width="10%">Category</th>
										<th width="5%">Featured</th>
										<th width="5%"><center>View</center></th>
										<th width="5%"><center>Type</center></th>
										<th width="25%"><center>Action</center></th>
									</tr>
								</thead>
								<?php
								while(($count < $rpp) && ($i < $tcount)) {
									mysqli_data_seek($result, $i);
									$data = mysqli_fetch_array($result);
									?>
									<tr>

										<td style="vertical-align: middle;"><?php echo $data['recipe_title'];?></td>

										<td style="vertical-align: middle;">
											<?php
											if ($data['content_type'] == 'youtube') { ?>
												<img class="img-corner-radius" style="object-fit:cover;" src="https://img.youtube.com/vi/<?php echo $data['video_id'];?>/mqdefault.jpg" height="60px" width="80px"/>
											<?php } else { ?>
												<img class="img-corner-radius" style="object-fit:cover;" src="upload/<?php echo $data['recipe_image'];?>" height="60px" width="80px"/>
											<?php } ?>
										</td>

										<td style="vertical-align: middle;"><?php echo $data['recipe_time'];?></td>
										<td style="vertical-align: middle;"><?php echo $data['category_name'];?></td>

										<td style="vertical-align: middle;"><center>
							            		<?php if ($data['featured'] == '0') { ?>
							            			<a href="featured.php?add=<?php echo $data['recipe_id'];?>" onclick="return confirm('Add to featured recipes?')" ><i class="material-icons" style="color:grey">lens</i></a>
							            		<?php } else { ?>
							            			<a href="featured.php?remove=<?php echo $data['recipe_id'];?>" onclick="return confirm('Remove from featured recipes?')" ><i class="material-icons" style="color:#2196f3">lens</i></a>
							            		<?php } ?>
										</center></td>

										<td style="vertical-align: middle;"><center><?php echo $data['total_views'];?></center></td>
										<td style="vertical-align: middle;"><center>
											<?php if ($data['content_type'] == 'Post') { ?>
											<span class="label label-rounded bg-blue">RECIPE</span>
											<?php } else { ?>
											<span class="label label-rounded bg-orange">VIDEO</span>
											<?php } ?>	
										</center></td>
										<td style="vertical-align: middle;"><center>

											<a href="recipes-send.php?id=<?php echo $data['recipe_id'];?>">
												<i class="material-icons">notifications_active</i>
											</a>	

											<a href="recipes-detail.php?id=<?php echo $data['recipe_id'];?>">
												<i class="material-icons">launch</i>
											</a>

											<a href="recipes-edit.php?id=<?php echo $data['recipe_id'];?>">
												<i class="material-icons">mode_edit</i>
											</a></center>
										</td>
									</tr>
									<?php
									$i++; 
									$count++;
								}
								?>
							</table>

						</form>

						<?php } ?>

						<?php if ($tcount > $postPerPage) { echo pagination($reload, $page, $keyword, $tpages); } ?>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>

<?php include_once('includes/footer.php'); ?>