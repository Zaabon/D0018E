<!doctype html>
<html>
	<head>
		<?php include 'connect.php';?>

		<meta charset="utf-8">
		<title>Test</title>


		<link href="stylesheat.css" rel="stylesheet" type="text/css">

	</head>

	<body>
		<div id="product">
		
			<p>
				<a href="index.php">Back to start</a>
				<?php
					$sql = "SELECT * FROM Articles where id='".$_GET['id']."'"; 
					foreach ($conn->query($sql) as $row) {
						echo "<p><h1>".$row['name']."</h1></p>";
						echo "<img src='gfx/".$row['picture']."' style='max-width:100px; max-height:100px;'>";
						echo "<p>Price: ".$row['price'].":-</p>";
						echo "<p>In stock: ".$row['stock']."</p>";
						echo "<p>Description: ".$row['description']."</p>";
						echo "<p>Category: <a href='category.php?category=".$row['category']."'>".$row['category']."</a></p>";
					}
			  	?>
			</p>
		</div>
	</body>
	<?php $conn = null; ?>
</html>