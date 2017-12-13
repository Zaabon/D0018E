<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<?php include 'connect.php';?>
		<title>FunProducts.se</title>
		<link href="stylesheet.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<div id="header">						
			<?php include("header_template.php");?>
		</div>
		<div id="messages">
			<?php 
				if( ! empty($_SESSION['login_error_msg']))
				{
				    echo "<p style='color: red;'>".$_SESSION['login_error_msg']."</p>";
				    unset($_SESSION['login_error_msg']);
				}
			?>
			
			<script>
				function orderView() {
					window.location = "orderView.php";
				}
			</script>
			
			<script>
				function order() {
					window.location = "order.php";
				}
			</script>
		
		
			<div id="content">
				<div id="top3">
					<h3>Newest products</h3>
					
					<?php $latest = "SELECT * FROM Articles ORDER BY id DESC LIMIT 3";
						
					foreach ($conn->query($latest) as $latestrow) {?>
						<div id = "category">
							<table>
								<td>
									<?php
										echo "<h3 style='margin-top: 0px; margin-bottom: 0px;'><a style='text-decoration: none; color: black;' href='product.php?id=".$latestrow['id']."'>".$latestrow['name']."</a></h3>";
										echo "<p style='margin-top: 0px;'><a href='product.php?id=".$latestrow['id']."'><img src='gfx/".$latestrow['picture']."' style='max-width:200px; max-height:150px; margin-right: 10px;'></a></p>";
									?>
								</td>
								<td>
									<?php
										echo "<p><b>Price: </b>".$latestrow['price'].":-</p>";
										echo "<p><b>In stock: </b>".$latestrow['stock']."</p>";
										echo "<p><b>Rate: </b>".round($latestrow['rate'], 1, PHP_ROUND_HALF_DOWN)."/5</p>";
									?>
									<table>
										<td>
											<form action="./buy.php" method="post">
												<?php
													echo '<input type="hidden" name="id" value="'.$latestrow["id"].'">';
													echo '<input type="hidden" name="price" value="'.$latestrow["price"].'">';
												?>
											  	<input type="number" name="quantity" min="1" style="width:40px" required>
												<input type="submit" id="buy" value="Buy" />
											</form>
										</td>
										<td>
											<?php //include 'wish_button.php';?>
										</td>
									</table>
								</td>
							</table>
						</div>
					<?php } ?>
					<form action="./search.php" method="get">
						<input type="submit" value="see more"/>
						<select name ="filters" hidden><option selected value="newest"/></select>
					</form>
				</div>
				<div style="clear:both;"></div>
				<div id="rated">
					<h3>Top rated products</h3>
					<?php $top = "SELECT * FROM Articles ORDER BY rate DESC LIMIT 3";
						
					foreach ($conn->query($top) as $toprow) {?>
						<div id = "category">
							<table>
								<td>
									<?php
										echo "<h3 style='margin-top: 0px; margin-bottom: 0px;'><a style='text-decoration: none; color: black;' href='product.php?id=".$toprow['id']."'>".$toprow['name']."</a></h3>";
										echo "<p style='margin-top: 0px;'><a href='product.php?id=".$toprow['id']."'><img src='gfx/".$toprow['picture']."' style='max-width:200px; max-height:150px; margin-right: 10px;'></a></p>";
									?>
								</td>
								<td>
									<?php
										echo "<p><b>Price: </b>".$toprow['price'].":-</p>";
										echo "<p><b>In stock: </b>".$toprow['stock']."</p>";
										echo "<p><b>Rate: </b>".round($toprow['rate'], 1, PHP_ROUND_HALF_DOWN)."/5</p>";
									?>
									<table>
										<td>
											<form action="./buy.php" method="post">
												<?php
													echo '<input type="hidden" name="id" value="'.$toprow["id"].'">';
													echo '<input type="hidden" name="price" value="'.$toprow["price"].'">';
												?>
											  	<input type="number" name="quantity" min="1" style="width:40px" required>
												<input type="submit" id="buy" value="Buy" />
											</form>
										</td>
										<td>
											<?php //include 'wish_button.php';?>
										</td>
									</table>
								</td>
							</table>
						</div>
					<?php } ?>
					<form action="./search.php" method="get">
						<input type="submit" value="see more"/>
						<select name ="filters" hidden><option selected value="highest rate"/></select>
					</form>
				</div>
				<div style="clear:both;"></div>
				<div id="rated" style="display: block;">
					<h3>Cheapest prices</h3>
					
					<?php $low = "SELECT * FROM Articles ORDER BY price ASC LIMIT 3";?>
					
					<?php foreach ($conn->query($low) as $lowrow) {?>
						<div id = "category">
							<table>
								<td>
									<?php
										echo "<h3 style='margin-top: 0px; margin-bottom: 0px;'><a style='text-decoration: none; color: black;' href='product.php?id=".$toprow['id']."'>".$lowrow['name']."</a></h3>";
										echo "<p style='margin-top: 0px;'><a href='product.php?id=".$lowrow['id']."'><img src='gfx/".$lowrow['picture']."' style='max-width:200px; max-height:150px; margin-right: 10px;'></a></p>";
									?>
								</td>
								<td>
									<?php
										echo "<p><b>Price: </b>".$lowrow['price'].":-</p>";
										echo "<p><b>In stock: </b>".$lowrow['stock']."</p>";
										echo "<p><b>Rate: </b>".round($lowrow['rate'], 1, PHP_ROUND_HALF_DOWN)."/5</p>";
									?>
									<table>
										<td>
											<form action="./buy.php" method="post">
												<?php
													echo '<input type="hidden" name="id" value="'.$lowrow["id"].'">';
													echo '<input type="hidden" name="price" value="'.$lowrow["price"].'">';
												?>
											  	<input type="number" name="quantity" min="1" style="width:40px" required>
												<input type="submit" id="buy" value="Buy" />
											</form>
										</td>
										<td>
											<?php //include 'wish_button.php';?>
										</td>
									</table>
								</td>
							</table>
						</div>
					<?php } ?>
					<form action="./search.php" method="get">
						<input type="submit" value="see more"/>
						<select name ="filters" hidden><option selected value="lowest price"/></select>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
