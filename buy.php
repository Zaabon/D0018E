<?php
include 'connect.php';

if(! $_SESSION['user']){
	$_SESSION['buy_error_msg'] = "Sorry, you can only buy products when logged in.";
}
else{
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
		$_SESSION['buy_error_msg'] = "Sorry, not enough products in stock.";
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

}

$conn = null;
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>