<?php
include 'connect.php';

$id = rand(10000000,99999999);

echo $id."<br>";
echo $_POST['email']."<br>";
echo $_POST['pwd']."<br>";

$check ="SELECT email from Accounts where email='".$_POST['email']."'";
$exists = false;
foreach($conn->query($check) as $row){
	$exists = true;
	echo "exists";
}

if($exists){
	$_SESSION['login_error_msg'] = "Sorry, this email is already used. Please try again.";
}
else{
	$sql = sprintf("INSERT into Accounts (id, email, pwd)
			VALUES (%u, '%s', '%s')", $id, $_POST['email'], password_hash($_POST['pwd'], PASSWORD_DEFAULT));
		
	echo $sql."<br>";
	$conn->query($sql);
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
$conn = null;
?>