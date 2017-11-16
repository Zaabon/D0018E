<!doctype html>
<html>
	<head>
		<?php include 'connect.php';?>

		<meta charset="utf-8">
		<title>Test</title>


		<link href="stylesheat.css" rel="stylesheet" type="text/css">

	</head>

	<body>
		<div id="category">
		
			<p>
				<a href="index.php">Back to start</a>
				<?php
					$sql = "SELECT * FROM Articles where category='".$_GET['category']."' ORDER by name"; 
					echo "<h1>".$_GET['category']."</h1>";
					foreach ($conn->query($sql) as $row) {
						
						echo "<a href='product.php?id=".$row['id']."'>".$row['name']."</a>";
						echo "<p><img src='gfx/".$row['picture']."' style='max-width:100px; max-height:100px;'></p>";
						echo "<p><b>Price: </b>".$row['price'].":-</p>";
						echo "<p><b>In stock: </b>".$row['stock']."</p>";
						echo "<p><b>Description: </b>".$row['description']."</p>";
						
					}
			  	?>
			</p>
		</div>
	</body>
	<?php $conn = null; ?>
</html>