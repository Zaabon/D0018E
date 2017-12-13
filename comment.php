<?php
	include 'connect.php';
	echo "Inserting comment... <br>";
	
	//echo $_POST['name']."<br>";
	//echo $_POST['comment']."<br>";
	//echo $_POST['product']."<br>";
	//echo $_POST['date']."<br>";
	
	$post = true;

	if($_POST['name']==''){
		echo "no name<br>";
		$post = false;
		$_SESSION['comment_error_msg'] = "Sorry, you need to fill in your name. Please try again.";
	}
	if($_POST['comment']==''){
		echo "no comment";
		$post = false;
		$_SESSION['comment_error_msg'] = "Sorry, you need to fill in a comment. Please try again.";
	}
	if($post){
		$sql = "INSERT INTO Comments (article_id, comment, name) VALUES ('".$_POST['product']."', '".$_POST['comment']."', '".$_POST['name']."')";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
	}

	
	
	//echo "<br><a href='".$_SERVER['HTTP_REFERER']."'>Go back</a>";
	$conn = null;
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	
?>