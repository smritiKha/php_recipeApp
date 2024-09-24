<?php ob_start(); ?>
<?php include_once('includes/header.php'); ?>

<?php
	
	if (isset($_GET['id'])) {
		$ID = clean($_GET['id']);
	} else {
		$ID = clean('');
	}

	// get image file from table
	$sql = "SELECT content_type, recipe_image, video_url FROM tbl_recipes WHERE recipe_id = '$ID'";
	$result = $connect->query($sql);
	$row = $result->fetch_assoc();

	$content_type = $row['content_type'];
	$recipe_image = $row['recipe_image'];
	$video_url = $row['video_url'];

	// delete data from menu table
	$sql_delete = "DELETE FROM tbl_recipes WHERE recipe_id = '$ID'";
	$delete = $connect->query($sql_delete);

	// if delete data success
	if ($delete) {
		if ($content_type == 'Upload') {

			$filePath = 'upload/'.$recipe_image;
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $videoPath = 'upload/video/'.$video_url;
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }

		} else if ($content_type == 'youtube') {
			//do nothing
		} else {

			$filePath = 'upload/'.$recipe_image;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
		}
		
		$_SESSION['msg'] = "Recipe deleted successfully...";
	    header( "Location: recipes.php");
	    exit;
	}

?>

<?php include_once('includes/footer.php'); ?>