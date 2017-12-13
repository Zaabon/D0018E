<?php
	include 'connect.php';
	
	$exists = false;
		
	$sql = "SELECT articleId FROM Wishlist WHERE userId = ".$_SESSION['user'];

	foreach ($conn->query($sql) as $row) {
		if($row['articleId'] == $_GET['id']){
			$exists = true;
			break;
		}
	}

	if(!$exists){
		$sql = "INSERT INTO Wishlist (userId, articleId) values (".$_SESSION['user'].", ".$_GET['id'].")";
		$conn->query($sql);
		echo "Add";
	}
	else{
		echo "Exists";
		$sql = "DELETE FROM Wishlist WHERE articleId = ".$_GET['id'];
		$conn->query($sql);
	}
	
	$conn = null;
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	
	
?>