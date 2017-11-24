<?php
include 'connect.php';

$id = rand(10000000,99999999);

echo $id."<br>";
echo $_POST['email']."<br>";
echo $_POST['pwd']."<br>";

$sql = sprintf("INSERT into Accounts (id, email, pwd)
		VALUES (%u, '%s', '%s')", $id, $_POST['email'], $_POST['pwd']);
		
echo $sql."<br>";

$conn->query($sql);
$conn = null;
?>