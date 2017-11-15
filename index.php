<!doctype html>
<html>
<head>
<?php include 'connect.php';?>

<meta charset="utf-8">
<title>Test</title>



<link href="stylesheat.css" rel="stylesheet" type="text/css">

</head>

<body style="background-color:#DDDDDD;">
	<div id="wrapper">
		<div id="header">
			<p>header</p>
		</div>
		<div id ="menu">
			<p>menu</p>				
			<?php
			if(isset($_SESSION["user"])) {
				echo "Logged in as ".$_SESSION['user']."<br>";
				echo "<button onclick='logOut();'>Log out</button>";
			}
			?>
			
		</div>
		<div id="content">
			<p><b>Sign up</b></p>
			<form action="/~olfjoh-5/login.php" method="post" id="form" name="form"> 

				<label for="name">Name:</label> <br />
				<input type="text" id="name" /> <br />

				<label for="email">Email:</label> <br />
				<input type="email" id="email" /> <br />

				<label for="password">Password:</label> <br />
				<input type="password" id="password" /> <br />

				<input type="submit" id="createAccount" value="Create" />

			</form>
			
			<br><br>
			<p><b>Sign in</b></p>			
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
			}?>

		<br><br>
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

		$sql = "SELECT * FROM Articles"; 
		foreach ($conn->query($sql) as $row) {
			?><tr>
			    <td><?php if(isset($row['picture'])) {
				echo "<img src='gfx/".$row['picture']."' style='max-width:100px; max-height:100px;'>";
			    } ?></td>
			    <td><?php echo "<a href='product.php?id=".$row['id']."'>";
				echo $row['name'];?></a></td>
			    <td><?php echo $row['price'].":-";?></td> 
			    <td><?php echo $row['description'];?></td>
			    <td><?php 



//echo "<input type='button' onclick='location.href=\"checkout.php?id=".$row['id']."\";' value='Buy' />";?>
			    </td>
			  </tr>
				
		
			

		<?php } ?>
		</table>


		</div>
	</div>



</body>

<?php $conn = null; ?>
</html>
