<?php	
	
include 'connect.php';


if(isset($_POST['logout'])) {
	$_SESSION['user'] = NULL;
}
else {
	// Parameterized query to prevent SQL injection
	$sql = "SELECT * FROM Accounts WHERE email=:email"; 
	$sth = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute(array(':email' => $_POST['email']));
	$user = $sth->fetchAll();

	$pwd = $user[0]['pwd'];
	
	if($_POST['pwd'] == $pwd) {
		echo "<br>Ok<br>";
		$_SESSION['user'] = $user[0]['id'];;
		echo "ID: ".$_SESSION["user"];
	
	}
	else {
		echo "Login failed";
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	echo "<br><a href='".$_SERVER['HTTP_REFERER']."'>Go back</a>";
}
$conn = null;


header('Location: ' . $_SERVER['HTTP_REFERER']);

?>