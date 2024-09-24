<?php include_once('includes/header.php'); ?>

<?php

	if (isset($_GET['id'])) {
		$ID = clean($_GET['id']);
	} else {
		$ID = "";
	}

	$qry    = "SELECT * FROM tbl_recipes WHERE recipe_id = '$ID'";
    $result = mysqli_query($connect, $qry);
    $data    = mysqli_fetch_assoc($result);

?>	

<section class="content">

	<ol class="breadcrumb breadcrumb-offset">
		<li><a href="dashboard.php">Dashboard</a></li>
		<li><a href="recipes.php">Manage Recipes</a></li>
		<li class="active">Recipes Detail</a></li>
	</ol>

	<div class="container-fluid" id="fade-in">

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<form method="post">
					<div class="card corner-radius">
						<div class="header">
							<h2>RECIPES DETAIL</h2>
							<div class="header-dropdown m-r--5" style="margin-right: 10px;">
                                <a href="recipes-edit.php?id=<?php echo $data['recipe_id'];?>"><i class="material-icons">mode_edit</i></a>
								<a href="recipes-delete.php?id=<?php echo $data['recipe_id'];?>" onclick="return confirm('Are you sure want to delete this Recipe?')" ><i class="material-icons">delete</i></a>
                            </div>
						</div>
						<div class="body">

							<div class="row clearfix">

								<div class="form-group form-float col-sm-12">

									<?php if (isset($_SESSION['msg'])) { ?>
									<div class='alert alert-info alert-dismissible corner-radius bottom-offset' role='alert'>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>&nbsp;&nbsp;</button>
										<?php echo $_SESSION['msg']; ?>
									</div>
									<?php unset($_SESSION['msg']); } ?>

									<p>
										<h4>
											<?php echo $data['recipe_title']; ?>
											
										</h4>
									</p>
									<p>
										<?php echo $data['recipe_time']; ?> 

									</p>

									<?php if ($data['content_type'] == 'youtube') { ?>
									<p><img class="img-corner-radius" style="max-width:40%" src="https://img.youtube.com/vi/<?php echo $data['video_id'];?>/mqdefault.jpg" ></p>
									<?php } else { ?>
									<p><img class="img-corner-radius" style="max-width:40%" src="upload/<?php echo $data['recipe_image']; ?>" ></p>
									<?php } ?>

									<p><?php echo $data['recipe_description']; ?></p>

								</form>

								</div>
							</div>
						</div>
					</div>

				</div>

			</div>

		</div>

	</section>

	<?php include_once('includes/footer.php'); ?>