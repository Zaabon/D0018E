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
		<div id="content">
			<div>
				<?php
					
					
					echo "<h1 style='margin-bottom: 0px;'>".$_GET['category']."</h1>";
					?>
					<form action="./filtered_category.php" method="get" style="margin-bottom: 10px;">
						<select name="category_filters">
							<option selected disabled hidden>Filter by</option>
							<option value="all">All</option>
							<option value="lowest price">Lowest price</option>
							<option value="highest price">Highest price</option>
							<option value="newest">Newest</option>
							<option value="highest rate">Highest rate</option>
							<option value="lowest rate">Lowest rate</option>
						</select>
						<input type="text" name ="category" hidden value ="<?php echo $_GET['category'] ?>"/>
						<input type="submit" value="Send"/>
					</form>
					
					<?php
					
					$catsql = "SELECT * FROM Articles where category='".$_GET['category']."' ORDER BY name";
					
					foreach ($conn->query($catsql) as $row) { ?>
						
						<div id = "category">
							<table>
								<td>
									<?php
										echo "<h3 style='margin-top: 0px; margin-bottom: 0px;'><a style='text-decoration: none; color: black;' href='product.php?id=".$row['id']."'>".$row['name']."</a></h3>";
										echo "<p style='margin-top: 0px;'><a href='product.php?id=".$row['id']."'><img src='gfx/".$row['picture']."' style='max-width:200px; max-height:150px; margin-right: 10px;'></a></p>";
									?>
								</td>
								<td>
									<?php
										echo "<p><b>Price: </b>".$row['price'].":-</p>";
										echo "<p><b>In stock: </b>".$row['stock']."</p>";
										echo "<p><b>Rate: </b>".round($row['rate'], 1, PHP_ROUND_HALF_DOWN)."/5</p>";
									?>
									<table>
										<td>
											<form action="./buy.php" method="post">
												<?php
													echo '<input type="hidden" name="id" value="'.$row["id"].'">';
													echo '<input type="hidden" name="price" value="'.$row["price"].'">';
												?>
											  	<input type="number" name="quantity" min="1" style="width:40px" required>
												<input type="submit" id="buy" value="Buy" />
											</form>
										</td>
										<td>
											<?php include 'wish_button.php';?>
										</td>
									</table>
								</td>
							</table>
							
						</div>
						<?php
					}
			  	?>
			</p>
		</div>
		</div>
	</body>
</html>
