<?php	
	
include 'connect.php';


if(isset($_POST['logout'])) {
	$_SESSION['user'] = NULL;
}
else {
	echo $_POST['email'];

	$sql = "SELECT * FROM Accounts WHERE Email='".$_POST['email']."'"; 
	foreach ($conn->query($sql) as $row) {
		    $pwd = $row['pwd'];
	}

	echo $_POST['pwd'];
	if($_POST['pwd'] == $pwd) {
		echo "<br>Ok<br>";
		$_SESSION['user'] = $row['id'];
		echo "ID: ".$_SESSION["user"];
	
	}
	else {
		echo "Login failed";
		header('Location: ' . $_SERVER['HTTP_REFERER']."?error=login");
	}

	echo "<br><a href='".$_SERVER['HTTP_REFERER']."'>Go back</a>";
}
$conn = null;


header('Location: ' . $_SERVER['HTTP_REFERER']);

?>