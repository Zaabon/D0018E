<?php
	include 'connect.php';
	
	echo "<p>Rate: ".$_POST['rating']."</p>";
	$user_rate = $_POST['rating'];
	echo "<p>Product ID: ".$_POST['product']."</p>";
	
	$sql = "SELECT rate, nr_rated, sum_rating FROM Articles WHERE id='".$_POST['product']."'";
	foreach ($conn->query($sql) as $row) {
		$rate = $row['rate'];
		$nr_rated = $row['nr_rated'];
		$sum_rating= $row['sum_rating'];			
	}
	
	$nr_rated = $nr_rated + 1;
	$sum_rating = $sum_rating + $user_rate;
	$rate = $sum_rating/$nr_rated;
	$sql2 = "UPDATE Articles SET rate ='".$rate."', nr_rated ='".$nr_rated."', sum_rating='".$sum_rating."' WHERE id='".$_POST['product']."'";
	$stmt = $conn->prepare($sql2);
	$stmt->execute();
	
	echo "new rate: ".$rate;
	
	echo "<br><a href='".$_SERVER['HTTP_REFERER']."'>Go back</a>";
	$conn = null;
?>