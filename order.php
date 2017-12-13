<?php
include 'connect.php';

if(isset($_GET['remove'])) {
	$sql = sprintf("DELETE FROM ShoppingCart WHERE customerID = %u AND articleID = %u", $_SESSION['user'], $_GET['remove']);
	$conn->query($sql);

	header('Location: ' . $_SERVER['HTTP_REFERER']); 
}

$ids = "";
foreach ($_POST['id'] as $id) {
	$ids .= $id.",";
}
$ids = chop($ids, ",");

$sql = "SELECT stock, id FROM Articles WHERE id in (".$ids.")";
echo "<br>".$sql."<br>";

$sql = $conn->prepare($sql);
$sql->execute();
$stock = $sql->fetchAll(PDO::FETCH_ASSOC);

$error = false;

for ($i = 0; $i < count($stock); $i += 1) {
	if($stock[$i]['stock'] < $_POST['quantity'][$i]) {
		$_SESSION['buy_error_msg'] = "Not enough products in stock.";
		echo "No stock";
		$stocksql = sprintf("DELETE FROM ShoppingCart WHERE customerID = %u AND articleID = %u", $_SESSION['user'], $stock[$i]['id']);
		$conn->query($stocksql);

		$error = true;
		break;
	}
}


if(!$error) {
	$sql = "UPDATE ShoppingCart
	   	SET quantity = CASE articleID";


	for ($i = 0; $i < count($_POST['id']); $i++) {
		$sql = sprintf("%s WHEN '%u' THEN '%u'", $sql, $_POST['id'][$i], $_POST['quantity'][$i]); 
	}

	$sql = $sql." ELSE 0 END WHERE customerID = ".$_SESSION['user'];
		echo $sql."<br>";

	$conn->query($sql);


	if (isset($_POST['checkout'])) {

		$sql = sprintf("SELECT price, quantity, articleID FROM ShoppingCart WHERE customerID='%u'", $_SESSION["user"]);

		$totalPrice = 0;
		$i = 0;
		foreach ($conn->query($sql) as $row) {
			$totalPrice += $row['price'] * $row['quantity'];
			$removeStock = sprintf("Update Articles SET stock ='%u' WHERE id = %u", $stock[$i]['stock'] - $row['quantity'], $row['articleID']);
			$conn->query($removeStock);
			$i += 1;
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
		
		header('Location: ' . $_SERVER['HTTP_REFERER']);

	}
}
else{
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
$conn = null; 
?>