<!doctype html>
<html>
<head>
<?php include 'connect.php';?>

<meta charset="utf-8">
<title>Test</title>

<link href="stylesheat.css" rel="stylesheet" type="text/css">
</head>

<body style="background-color:#DDDDDD;">
	<div id="wrapper">
		<div id="content">
			<b>Orders</b><br>
		
			<?php
			$sql = sprintf("SELECT orderID, date, totalPrice FROM Orders WHERE customerID = %u", $_SESSION['user']);
			foreach ($conn->query($sql) as $row) {
				
				echo "Order ID: ".$row['orderID'];
				echo "<br>Date: ".$row['date'];
				echo "<br>Total price: ".$row['totalPrice'];
				
				$sql = sprintf("SELECT * FROM OrderArticles WHERE orderID = %u", $row['orderID']);
				?>
				<table>
				<tr>
					<th>ArticleID</th>
					<th>Quantity</th> 
					<th>Price</th>
					<th></th>
				</tr>
				<?php 
				foreach ($conn->query($sql) as $row) {
					echo "<tr>";
					echo "<th>".$row['articleID']."</th>";
					echo "<th>".$row['quantity']."</th>";
					echo "<th>".$row['price'] * $row['quantity'].":-</th>";
					echo "</tr>";
				}	?>
				</tr>   
				</table>
				<br><br>
				<?php } ?>
			</table>
		</div>
	</div>
</body>
</html>

<?php $conn = null; ?>