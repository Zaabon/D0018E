<?php
include 'connect.php';

$sql = sprintf("SELECT quantity FROM ShoppingCart WHERE customerID='%u' AND articleID='%u'", $_SESSION["user"], $_POST['id']);
$sql = $conn->prepare($sql);
$sql->execute();
$quantity = $sql->fetch(PDO::FETCH_ASSOC);

if(isset($quantity['quantity'])) {
	echo "Quantity = ".$quantity['quantity']."<br>";
	$sql = sprintf("UPDATE ShoppingCart SET quantity='%u' WHERE customerID='%u' AND articleID='%u'", $quantity['quantity'] + $_POST['quantity'], $_SESSION["user"], $_POST['id']);
}
else {
	$sql = sprintf("INSERT INTO ShoppingCart (customerID, articleID, quantity, price)
		VALUES (%u, '%u', '%u', '%u')", $_SESSION["user"], $_POST['id'], $_POST['quantity'], $_POST['price']);	
	echo $sql."<br>";
}

$conn->query($sql);



$conn = null;
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>