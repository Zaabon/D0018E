<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="stylesheet.css" rel="stylesheet" type="text/css">
		<?php include 'connect.php';?>
		<title>Search Results</title>
	</head>

	<body>
		<div id="header">
			<?php include("header_template.php");?>
		</div>
		<div id="content">
			<?php
				
				if($_GET['filters']=='all'){
					$order = "";
				}
				else if($_GET['filters']=='lowest price'){
					$order = "ORDER BY price ASC";
				}
				else if($_GET['filters']=='highest price'){
					$order = "ORDER BY price DESC";
				}
				else if($_GET['filters']=='newest'){
					$order = "ORDER BY ID DESC";
				}
				else if($_GET['filters']=='highest rate'){
					$order = "ORDER BY rate DESC";
				}
				else if($_GET['filters']=='lowest rate'){
					$order = "ORDER BY rate ASC";
				}
	
				if(isset($_GET['search']) && $_GET['search'] != "") {
					echo "You searched for '".$_GET['search']."' with filter '".$_GET['filters']."'.";
					$sql = "SELECT * FROM Articles WHERE name LIKE '%".$_GET['search']."%' OR category='".$_GET['search']."' ".$order;

					$tags = $conn->prepare("SELECT articleID FROM Tags WHERE tag='".$_GET['search']."'");
					$tags->execute();
					$ids = $tags->fetchALL(PDO::FETCH_COLUMN);
					
					if(count($ids) > 0) {
						$ids = implode(",", $ids);
					 	$sql = $sql." OR id IN (".$ids.")"; 
					}
				}
				else{
					$sql = "SELECT * FROM Articles ".$order;
				}?> 
				
				<table> <?php
	
					foreach ($conn->query($sql) as $row) {?>
						<tr style="display: table; border: 3px dashed black; margin-bottom: 5px; text-align: left;">
		
							<td style="width: 105px;">
								<?php if(isset($row['picture'])) {
									echo "<a href='product.php?id=".$row['id']."'><img src='./gfx/".$row['picture']."' style='max-width:100px; max-height:100px;'></a>";
								} ?>
							</td>
						 	<td style="width: 200px;">
						 		<?php echo "<a style='text-decoration: none; color: black;' href='product.php?id=".$row['id']."'>";
								echo $row['name'];?></a>
							</td>
						 	<td style="width: 50px;">
						 		<?php echo $row['price'].":-";?></td> 
						 	<td style="width: 50px;">
						 		<?php echo round($row['rate'], 1, PHP_ROUND_HALF_DOWN)."/5";?></td>
						 	<td style="width: 100px;">
							 	<form action="./buy.php" method="post">
									<?php
										echo '<input type="hidden" name="id" value="'.$row["id"].'">';
										echo '<input type="hidden" name="price" value="'.$row["price"].'">';
									?>
								  	<input type="number" name="quantity" min="1" style="width:40px" required>
									<input type="submit" id="buy" value="Buy" />
								</form>
			
							</td>
							<td style="width: 15px;">
				
								<?php include 'wish_button.php';?>
							</td>
		
						</tr>
					<?php } ?>
				</table>
		</div>
	</body>
</html>
