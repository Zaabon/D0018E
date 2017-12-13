<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="stylesheet.css" rel="stylesheet" type="text/css">
		<title>Toplist</title>
		<?php include 'connect.php';?>
	</head>

	<body>
		<div id="header">
			<?php include("header_template.php");?>
		</div>
		<div id="content">
			<div id="highest_rates">
		
				<h4 style="margin-bottom: 5px; margin-top: 0px;">Top 10 highest rates: </h4>
				
				<?php
					$nr =1;
					$sql = "SELECT * FROM Articles ORDER BY rate DESC";
					foreach ($conn->query($sql) as $row) { ?>
						
						<div id = "top_rated">
							<?php
								echo "<h3 style='margin: 0px;'>".$nr.". <a style='text-decoration:none; color: black;' href='product.php?id=".$row['id']."'>".$row['name']."</a></h3>";
							?>
							<table>
								<td>
									<?php
										echo "<p><b>Rated:</b> ".round($row['rate'], 1)."/5<p>";
									?>
								</td>
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
							</table>
							<?php
								echo "<p style='margin-top: 0px;'><a href='product.php?id=".$row['id']."'><img src='gfx/".$row['picture']."' style='max-width:150px; max-height:100px;'></a></p>";
							?>
							
						</div>
						<?php
						$nr = $nr+1;
						if($nr>10){
							break;
						}
					}
			  	?>
			</div>
		</div>
	</body>
</html>