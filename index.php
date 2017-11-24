<!doctype html>
<html>
<head>
<?php include 'connect.php';
?>

<meta charset="utf-8">
<title>Test</title>



<link href="stylesheat.css" rel="stylesheet" type="text/css">


</head>

<body style="background-color:#DDDDDD;">
	<div id="wrapper">
		<div id="header">

		</div>
		<div id ="menu">
			
		</div>
		<div id="content">
			<script>
				function orderView() {
					window.location = "orderView.php";
				}
			</script>
			<?php
			
			if(isset($_SESSION["user"])) {
				echo "Logged in as ".$_SESSION['user']."<br>"; ?>
				<form action="/~olfjoh-5/login.php" method="post">
				<input type="hidden" name="logout" value="1">
				<input type="submit" id="log out" value="Log out" />
				</form>
				<button onclick='orderView();'>View orders</button>
				<br><br>
			<?php } 
			else { ?>
				<p><b>Sign up</b></p>
				<form action="/~olfjoh-5/signUp.php" method="post" id="form" name="form"> 
					<label for="email">Email:</label> <br />
					<input type="email" id="email" name="email" /> <br />

					<label for="password">Password:</label> <br />
					<input type="password" id="pwd" name="pwd" /> <br />

					<input type="submit" id="createAccount" value="Create" />

				</form>
			
				<br><br>
				<p><b>Login</b></p>			
				<form action="/~olfjoh-5/login.php" method="post">
				  	Email:<br>
				 	 <input type="text" name="email"><br>
					Password:<br>
				 	 <input type="password" name="pwd"><br>

					<input type="submit" id="login" value="Login" />
				</form>
				<?php if(isset($_GET['error'])) {
					if($_GET['error'] === "login") {
						echo "<br><font color='red'>Incorrect email or password</font>";
					}
				}
			}?>
		<br>
		<div style="width:100%; border-style:solid; border-width:1px;"></div>
		<br><br>
	
		<script>
		function order() {
			window.location = "order.php";
		}
		</script>
		<?php ////////////////////////////// Shopping cart
		if(isset($_SESSION["user"])) { 
			$sql = "SELECT 1 FROM ShoppingCart WHERE customerID = ".$_SESSION['user'];
			$sql = $conn->prepare($sql);
			$sql->execute();
			$isset = $sql->fetch(PDO::FETCH_ASSOC);
			if($isset) { ?>
				<b>Shopping cart</b><br>
				<table>
				<tr>
				<th>Name</th>
				<th>Quantity</th>
				<th>Price</th>
				</tr>
			
				<?php
				$articles = "
				SELECT name FROM Articles WHERE id IN (
					SELECT articleID FROM ShoppingCart WHERE customerID = ".$_SESSION['user']."
				)";
			
				$cart = "SELECT quantity, price FROM ShoppingCart WHERE customerID = ".$_SESSION['user'];
				$cart = $conn->prepare($cart);
				$cart->execute();
			
				foreach ($conn->query($articles) as $row) {
					$result = $cart->fetch(PDO::FETCH_ASSOC);
	
		    		echo "<tr>";
		    		echo "<td>".$row['name']."</td>";
		    		echo "<td>".$result['quantity']."</td>";
		    		echo "<td>".$result['price'] * $result['quantity'].":-</td>";
		    		echo "</tr>";
		    	}
		    	echo "</table><br>";
		    	echo '<button onclick="order()">Go to chekout</button><br><br>';
        	}
        }
       
		
		
		
		/////////////////////////////////////// Search
		?>
		<br>
		<form action="/~olfjoh-5/index.php" method="get">
		<input type="text" name="search">
		<input type="submit" id="search" value="Search" />
		</form>
		<br>
		<?php
		if(isset($_GET['search'])) {
			$sql = "SELECT * FROM Articles WHERE name LIKE '%".$_GET['search']."%' OR category='".$_GET['search']."'";
			
			$tags = $conn->prepare("SELECT articleID FROM Tags WHERE tag='".$_GET['search']."'");
			$tags->execute();
			$ids = $tags->fetchALL(PDO::FETCH_COLUMN);
			if(count($ids) > 0) {
				$ids = implode(",", $ids);
			 	$sql = $sql." OR id IN (".$ids.")"; 
			}
		}
		else {
			$sql = "SELECT * FROM Articles"; 
		}
		?>
		
	
		<b>Articles</b><br>
		<table>
		<tr>
			<th></th>
	    	<th>Name</th>
    		<th>Price</th> 
    		<th>Description</th>
			<th></th>
		</tr>
		<?php
		foreach ($conn->query($sql) as $row) {
				?><tr>
			    <td><?php if(isset($row['picture'])) {
				echo "<img src='gfx/".$row['picture']."' style='max-width:100px; max-height:100px;'>";
			    } ?></td>
			    <td><?php echo "<a href='product.php?id=".$row['id']."'>";
				echo $row['name'];?></a></td>
			    <td><?php echo $row['price'].":-";?></td> 
			    <td><?php echo $row['description'];?></td>
			    <td>
			    <form action="/~olfjoh-5/buy.php" method="post">
				<?php echo '<input type="hidden" name="id" value="'.$row["id"].'">';
				echo '<input type="hidden" name="price" value="'.$row["price"].'">';?>
			  	<input type="number" name="quantity" min="1" style="width:40px" required>
				<input type="submit" id="buy" value="Buy" />
			</form>
			    
			    
			    
			    </td>
			  </tr>
		<?php } ?>
		</table>


		</div>
	</div>



</body>

<?php $conn = null; 
?>
</html>
