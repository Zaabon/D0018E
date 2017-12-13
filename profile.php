<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="stylesheet.css" rel="stylesheet" type="text/css">
		<?php include 'connect.php';?>
		<title>My Profile</title>
	</head>

	<body>
		<div id="header">
			<?php include("header_template.php");?>
		</div>
		<div id="content">
			
			<div class="user_info">
				<h1>Orders</h1>
		
				<?php
				$sql = sprintf("SELECT orderID, date, totalPrice FROM Orders WHERE customerID = %u", $_SESSION['user']);
				foreach ($conn->query($sql) as $row) {
				
					echo "<b>Order ID:</b> ".$row['orderID'];
					echo "<br><b>Date:</b> ".$row['date'];
					echo "<br><b>Total price:</b> ".$row['totalPrice'].":-";
				
					$sql = sprintf("SELECT * FROM OrderArticles WHERE orderID = %u", $row['orderID']);
					?>
					<table>
					<tr style="text-align: left;">
						<!--<th>ArticleID</th>-->
						<th>Name</th>
						<th>Quantity</th> 
						<th>Price</th>
						<th></th>
					</tr>
					<?php 
					foreach ($conn->query($sql) as $row) {
						echo "<tr>";
						//echo "<td>".$row['articleID']."</td>";
					
						$namesql = "SELECT name, id FROM Articles WHERE id=".$row['articleID']." ORDER by name";
						foreach ($conn->query($namesql) as $namerow) {
							echo "<td><a href='product.php?id=".$namerow['id']."'>".$namerow['name']."<a></td>";
						}
					
					
						echo "<td>".$row['quantity']."</td>";
						echo "<td>".$row['price'] * $row['quantity'].":-</td>";
						echo "</tr>";
					}	?>
					</tr>   
					</table>
					<br><br>
					<?php } ?>
				</table>
			</div>
			<div class="user_info">
				<h1>Personal info</h1>
				<?php
					$sql = sprintf("SELECT * FROM Accounts WHERE id = %u", $_SESSION['user']);
					foreach ($conn->query($sql) as $row) {
						echo "<b>Email:</b> ".$row['email']."<br>";
					}
					
				?>
				
				<form action="./login.php" method="post">
					<h2>Change Password:</h2>
					Old password:<br>
					<input type="password" name="old_pwd"/><br>
					New password:<br>
					<input type="password" name="new_pwd"/><br>
					<input type="submit" name="change_pwd" value="Change password" id="buy"/>
				</form>
				
				<form method="post">
					<h2>Change Email:</h2>
					New Email:<br>
					<input type="email" name="new_email"/><br>
					<input type="submit" name="change_email" value="Change email" id="buy"/>
				</form>
				
				<?php
					if(isset($_POST['change_email'])){
						$check ="SELECT email from Accounts where email='".$_POST['new_email']."'";
						$exists = false;
						foreach($conn->query($check) as $row){
							$exists = true;
						}

						if($exists){
							$_SESSION['login_error_msg'] = "Sorry, this email is already used. Please try again.";
						}
						else{
							$emailsql = "UPDATE Accounts SET email ='".$_POST['new_email']."' WHERE id = ".$_SESSION['user'];
							$stmt = $conn->prepare($emailsql);
							$stmt->execute();
						}
					}
				?>
				
			</div>
		<div class="user_info" style="max-width: 610px;">
				<h1>Wishlist</h1>
				<?php
					$sql = "SELECT * FROM Wishlist where userId = ".$_SESSION['user'];
					foreach ($conn->query($sql) as $row) {
						$namesql = "SELECT name, id, picture FROM Articles where id = ".$row['articleId'];
						foreach ($conn->query($namesql) as $namerow) {?>
							<div style="border-color: black; border-width: 1px; border-style: dashed; float: left; height: 150px; width: 150px; text-align: center; vertical-align: middle;">
								<?php
									echo "<a href='product.php?id=".$namerow['id']."'>".$namerow['name']."</a><br>";
									echo "<a href='product.php?id=".$namerow['id']."'><img src='./gfx/".$namerow['picture']."' style='max-width:100px; max-height:100px;'></a><br>";
									
									echo "<button class='login'><a href='./wishlist.php?id=".$namerow['id']."'>Remove</a></button>";
								?>
							</div>
							<?php
						}
					}
				?>
			</div>
		</div>
	</body>
</html>
