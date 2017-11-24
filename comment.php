<?php
	include 'connect.php';
	echo "Inserting comment... <br>";
	
	echo $_POST['name']."<br>";
	echo $_POST['comment']."<br>";
	echo $_POST['product']."<br>";
	echo $_POST['date']."<br>";
	
	$sql = "INSERT INTO Comments (article_id, comment, name, time) VALUES ('".$_POST['product']."', '".$_POST['comment']."', '".$_POST['name']."', '".$_POST['date']."')";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	
	echo "<br><a href='".$_SERVER['HTTP_REFERER']."'>Go back</a>";
	$conn = null;
?>