<?php include 'connect.php';


if(isset($_GET['remove'])) {
	$query1 = "DELETE FROM Articles WHERE id = ".$_GET['id']."";
	$query2 = "DELETE FROM Tags WHERE articleID = ".$_GET['id']."";
	$query3 = "DELETE FROM Comments WHERE article_id = ".$_GET['id']."";
	$query4 = "DELETE FROM ShoppingCart WHERE articleID = ".$_GET['id']."";
	
	$conn->beginTransaction(); 
	$conn->exec($query1);
	$conn->exec($query2);
	$conn->exec($query3);
	$conn->exec($query4);
	$conn->commit();
	
	$conn = null;
	header('Location: index.php');
}
else if(isset($_POST['edit'])) {
	$sql = sprintf("UPDATE Articles SET name = '%s', price = '%u', stock = '%u', category = '%s', description = '%s' WHERE id='%u';", 
						$_POST['name'], $_POST['price'], $_POST['stock'], $_POST['category'], $_POST['description'], $_POST['id']);
	echo $sql;
	
	
	$conn->beginTransaction(); 
	$conn->exec($sql);

	$query = "DELETE FROM Tags WHERE articleID = ".$_POST['id']."";
	$conn->exec($query);
		
	if(isset($_POST['tags'])) {
		$tagArr = explode(',', $_POST['tags']);
		
	    foreach($tagArr as $tag) {
			$sql = "INSERT INTO Tags (articleID, tag) 
    			VALUES ('".$_POST['id']."', '".$tag."')";
    		echo "<br>".$sql;
			$conn->exec($sql);
		}
	}
	$conn->commit();
	
	$conn = null;
	header('Location: ' . $_SERVER['HTTP_REFERER']); 
}
else if(isset($_POST['create'])) {
	
	echo $_POST['name'];
	echo "<br>";
	echo $_POST['price'];
	echo "<br>";
	echo $_POST['stock'];
	echo "<br>";
	echo $_POST['category'];
	echo "<br>";
	echo $_POST['tags'];
	echo "<br>";
	echo $_POST['description'];
	echo "<br>";
	echo "---<br>";
	
	$sql = sprintf("INSERT INTO Articles (name, price, stock, category, description, rate, nr_rated, sum_rating) 
						VALUES ('%s', '%u', '%u', '%s', '%s', 0, 0, 0)", $_POST['name'], $_POST['price'], $_POST['stock'], $_POST['category'], $_POST['description']);
						
	
	echo $sql."<br>";
	
	$conn->beginTransaction(); 
	$sql = $conn->prepare($sql);
	$sql->execute();
	$id = $conn->lastInsertId(); 
	$conn->commit();
	
	echo $id;
	
	
	if(isset($_POST['tags'])) {
		$tagArr = explode(',', $_POST['tags']);
		
		
	    $conn->beginTransaction();
		foreach($tagArr as $tag) {
			$sql = "INSERT INTO Tags (articleID, tag) 
    			VALUES ('".$id."', '".$tag."')";
    		echo "<br>".$sql;
			$conn->exec($sql);
		}
	    $conn->commit();

	}
	
	/*// Code from https://www.w3schools.com/php/php_file_upload.asp to upload image. Would work if we had root permission. 
	$target_dir = "gfx/";
	$target_file = $target_dir . basename($_FILES["image"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
		    $_SESSION['image_error_msg'] =  "File is an image - " . $check["mime"] . ".";
		    $uploadOk = 1;
		} else {
		    $_SESSION['image_error_msg'] =  "File is not an image.";
		    $uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		$_SESSION['image_error_msg'] =  "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["image"]["size"] > 500000) {
		$_SESSION['image_error_msg'] =  "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		$_SESSION['image_error_msg'] =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$_SESSION['image_error_msg'] =  "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		    $_SESSION['image_error_msg'] =  "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} else {
		    $_SESSION['image_error_msg'] =  "Sorry, there was an error uploading your file.";
		}
	}*/
	
	$conn = null;
	header('Location: ' . $_SERVER['HTTP_REFERER']); 
} 


?>