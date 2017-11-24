<?php
include 'connect.php';

$sql = sprintf("SELECT price, quantity FROM ShoppingCart WHERE customerID='%u'", $_SESSION["user"]);

$totalPrice = 0;
foreach ($conn->query($sql) as $row) {
	$totalPrice += $row['price'] * $row['quantity'];
}
if($totalPrice == 0) {
	$conn = null;
	header('Location: ' . $_SERVER['HTTP_REFERER']); // Nothing to place order on, go back.
}

$sql = sprintf("INSERT INTO Orders (customerID, totalPrice) VALUES ('%u', '%u')", $_SESSION['user'], $totalPrice);
$conn->beginTransaction(); 
$sql = $conn->prepare($sql);
$sql->execute();
$orderID = $conn->lastInsertId(); 
$conn->commit();

echo $orderID;

$sql = sprintf("SELECT articleID, quantity, price FROM ShoppingCart WHERE customerID = '%u'", $_SESSION['user']);

$query = "INSERT INTO OrderArticles(orderID, articleID, quantity, price) VALUES ";
foreach ($conn->query($sql) as $row) {
	$append = sprintf("(%u, %u, %u, %u),", $orderID, $row['articleID'], $row['quantity'], $row['price']);
	$query = $query.$append;
}
$query = chop($query, ",");
echo "<br>".$query;

$conn->query($query);

$sql = sprintf("DELETE FROM ShoppingCart WHERE customerID = '%u'", $_SESSION['user']);
$conn->query($sql);



$conn = null;
?>