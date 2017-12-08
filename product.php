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
					
					// Check if admin
					if(isset($_SESSION['user'])) {
						$query = "SELECT isAdmin FROM Accounts WHERE id =".$_SESSION['user'];
						$query = $conn->prepare($query);
						$query->execute();
						$result = $query->fetch(PDO::FETCH_ASSOC);
					}
					
					foreach ($conn->query($sql) as $row) {						
						if(isset($result['isAdmin'])) {
							if($result['isAdmin']) {
								echo "<br><br><b>Admin tools</b>";
								echo "<br><a href='admin.php?id=".$row['id']."'><button>Edit article</button></a>";
								echo "<br><a href='adminFunctions.php?remove=1&id=".$row['id']."'><button>Delete article</button></a>";
							} 
						}

						echo "<p><h1>".$row['name']."</h1></p>";
						echo "<img src='gfx/".$row['picture']."' style='max-width:100px; max-height:100px;'>";
						echo "<p>Price: ".$row['price'].":-</p>";
						echo "<p>In stock: ".$row['stock']."</p>";
						echo "<p>Description: ".$row['description']."</p>";
						echo "<p>Rate: ".round($row['rate'], 1, PHP_ROUND_HALF_DOWN)."</p>";
						echo "<p>Category: <a href='category.php?category=".$row['category']."'>".$row['category']."</a></p>";
					}
			  	?>
			</p>
			
			<div id="rate">
				<h3>Rate: </h3>
				<form action="./rate.php" method="post" id="rate_form" name="rate_form">
					<span class="rating">
					  <input id="rating1" type="radio" name="rating" value="1" required>
					  <label for="rating1">1</label>
					  <input id="rating2" type="radio" name="rating" value="2">
					  <label for="rating2">2</label>
					  <input id="rating3" type="radio" name="rating" value="3">
					  <label for="rating3">3</label>
					  <input id="rating4" type="radio" name="rating" value="4">
					  <label for="rating4">4</label>
					  <input id="rating5" type="radio" name="rating" value="5">
					  <label for="rating5">5</label>
					  <input type="hidden" name="product" value="<?php echo $_GET['id'];?>">
					  <input type="submit" value="Submitt"/>
					</span>
				</form>
			</div>
			
			<div id="comment">
				<?php
					echo "<h2>Comments:</h2>";
					$sql2 = "SELECT * FROM Comments where article_id='".$_GET['id']."'";
					foreach ($conn->query($sql2) as $row) {
						echo "<p><h3>".$row['name']."</h3></p>";
						echo "<p>".$row['time']."</p>";
						echo "<p>".$row['comment']."</p>";
					}
				?>
				
				<form action="./comment.php" method="post" id="comment_form" name="comment_form">
					<p>
						Name: <br>
						<input type="text" id="name" name="name"/> <br>
						Comment: <br>
						<input type="text" id="comment"name="comment"/> <br>
						<input type="hidden" name="product" value="<?php echo $_GET['id'];?>">
						<input type="hidden" name="date" value="<?php echo date("Y-m-d h:i:s");?>">
						<input type="submit" id="leave_comment" value="Send">
					</p>
				</form>
			</div>
		</div>
	</body>
	<?php $conn = null; ?>
</html>