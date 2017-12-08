<?php
include 'connect.php';

$sql = sprintf("SELECT quantity FROM ShoppingCart WHERE customerID='%u' AND articleID='%u'", $_SESSION["user"], $_POST['id']);
$sql = $conn->prepare($sql);
$sql->execute();
$quantity = $sql->fetch(PDO::FETCH_ASSOC);


// Compare with stock
$buy = $_POST['quantity'];

if(isset($quantity['quantity'])) {
	$buy += $quantity['quantity'];
}

$sql = "SELECT stock FROM Articles WHERE id = ".$_POST['id'];
$sql = $conn->prepare($sql);
$sql->execute();
$article = $sql->fetch(PDO::FETCH_ASSOC);

if($buy > $article['stock']) {
	echo "Error: Out of stock";
	$_SESSION['buy_error'] = "Not enough products in stock.";
}
else {
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
}


$conn = null;
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>