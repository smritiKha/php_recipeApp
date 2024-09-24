<?php ob_start(); ?>
<?php include_once('includes/header.php'); ?>

<?php
	
	if (isset($_GET['id'])) {
		$ID = clean($_GET['id']);
	} else {
		$ID = clean("");
	}

	$sql = "SELECT COUNT(*) as num FROM tbl_recipes WHERE cat_id = '$ID'";
	$recipes = $connect->query($sql);
  	$recipes = $recipes->fetch_array();
  	$recipes = $recipes['num'];

  	if ($recipes > 0) {
        $_SESSION['msg'] = "Categories cannot be deleted because there are still active recipes";
        header( "Location:category.php");
        exit;

  	} else {

		// get image file from table
		$sql_image = "SELECT category_image FROM tbl_category WHERE cid = '$ID'";
		$result = $connect->query($sql_image);
		$row = $result->fetch_assoc();
		$category_image = $row['category_image'];

		// delete data from menu table
		$sql_delete = "DELETE FROM tbl_category WHERE cid = '$ID'";
		$delete = $connect->query($sql_delete);

		// if delete data success
		if ($delete) {
			$filePath = 'upload/category/'.$category_image;
			if (file_exists($filePath)) {
				unlink($filePath);
			}
			
			$_SESSION['msg'] = "Category deleted successfully...";
	        header( "Location: category.php");
	        exit;
		}

	}

?>

<?php include_once('includes/footer.php'); ?>