<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<?php include 'connect.php';?>
		<title>FunProducts.se</title>
		<link href="./stylesheet.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<div id="header">
			<?php include("header_template.php");?>
		</div>
		<div id="content">
			<div id="product">
			<table>
				<tr>
					<td style="vertical-align: top;">
						<table class="product_info">
							<tr>
								<?php	$sql = "SELECT * FROM Articles where id='".$_GET['id']."'"; 
									foreach ($conn->query($sql) as $row) { ?>
						
										<td style="padding-right: 20px;">
											<?php	echo "<img src='gfx/".$row['picture']."' style='max-width:300px; max-height:300px;'>";?>
										</td>
										<td>
											<?php	
												echo "<h1 style='margin-bottom: -15px; margin-top: 0px;'>".$row['name']."</h1>";
												echo "<h2 style='color:red; margin-bottom: 0px;'>".$row['price'].":-</h2>";
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
											<?php
												echo "<h3 style='margin-bottom: -10px;'><u>About The product</u></h3>";
												echo "<p style='max-width: 350px;'>".$row['description']."</p>";
												echo "<p><b>In stock:</b> ".$row['stock']."</p>";
												echo "<p><b>Rate:</b> ".round($row['rate'], 1, PHP_ROUND_HALF_DOWN)."/5 (".$row['nr_rated']." ratings in total)</p>";
												echo "<p><b>Category:</b> <a href='category.php?category=".$row['category']."'>".$row['category']."</a></p>";
												
												if(isset($result['isAdmin'])) {
							if($result['isAdmin']) {
								echo "<h4 style='margin-bottom: 0px;'>Admin tools</h4>";
								echo "<a href='admin.php?id=".$row['id']."'><button>Edit article</button></a>";
								echo "<a href='adminFunctions.php?remove=1&id=".$row['id']."'><button>Delete article</button></a>";
							} 
						}
											}?>	
										</td>
							</tr>
						</table>
					</td>
					<td style="vertical-align: top;">
						<table class="reviewpanel">
							<tr>
								<td>
									<div id="rate">
										<h3 style="margin-top: 0px; margin-bottom: -1px;"><u>Rate product</u></h3>
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
											  <br><input type="submit" id="buy" value="Submit"/>
											</span>
										</form>
									</div>
									
									<div id="comment">
										<form action="./comment.php" method="post" id="comment_form" name="comment_form">
											<p>
												<h3 style="margin-bottom: 0px; margin-top: 25px;"><u>Comment on product</u></h3>
												<input type="text" id="name" name="name" placeholder="Name" required=true/> <br>
												<textarea type="text" id="comment"name="comment" placeholder="Comment" rows="6" cols="40" required=true></textarea> <br>
												<input type="hidden" name="product" value="<?php echo $_GET['id'];?>">
												<input type="submit" id="buy" value="Submit">
											</p>
										</form>
										<?php 
										if( ! empty($_SESSION['comment_error_msg']))
										{
										    echo "<p style='color: red;'>".$_SESSION['comment_error_msg']."</p>";
										    unset($_SESSION['comment_error_msg']);
										}
									
										
										?>
										
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
			
			
			<div id="comments">
				<?php
					$sql2 = "SELECT * FROM Comments where article_id='".$_GET['id']."'";
					foreach ($conn->query($sql2) as $row) { ?>
						
						<div class="comment">
							<?php
							echo "<p><h3 style='margin-top: -10px; margin-bottom: -10px;'>".$row['name']."</h3></p>";
							echo "<p>".$row['time']."</p>";
							echo "<p>".$row['comment']."</p>";
if(isset($result['isAdmin'])) {
											if($result['isAdmin']) {
												echo '<form action="./adminFunctions.php" method="post">
														<input type="hidden" name="id" value="'.$row["id"].'">
													<input type="submit" name="commentRemove" value="Remove" />
												</form>';
											}
										}							
							?>
							
						</div>
						
						
					<?php }
				?>
			</div>
		</div>
		</div>
	</body>
</html>


