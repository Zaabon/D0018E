<!doctype html>
<html>
<head>
<?php include 'connect.php';?>

<meta charset="utf-8">
<title>Test</title>



<link href="stylesheat.css" rel="stylesheet" type="text/css">

</head>

<body>
	<div id="wrapper">
		<div id="header">
			<p>head</p>
		</div>
		<div id ="menu">
			<p>menu</p>
		</div>
		<div id="content">
			<p>content</p>

			<form action="/~emeker-5/login.php" method="post" id="form" name="form"> 

				<label for="name">Name:</label> <br />
				<input type="text" id="name" /> <br />

				<label for="email">Email:</label> <br />
				<input type="email" id="email" /> <br />

				<label for="password">Password:</label> <br />
				<input type="password" id="password" /> <br />

				<input type="submit" id="createAccount" value="Create" />

			</form>
<br><br>

			<form action="/~emeker-5/login.php" method="post">
			  	Email:<br>
			 	 <input type="text" name="email">
			 	 <input type="text" name="pwd">

				<input type="submit" id="createAccount" value="Create" />
			</form>

		</div>
		<b>Articles</b><br>
		<table>
			<tr>
	    	<th>Name</th>
    		<th>Price</th> 
    		<th>Description</th>
		</tr>
	<?php

	$sql = "SELECT * FROM Articles"; 
	foreach ($conn->query($sql) as $row) {
		?><tr>
		    <td><?php echo $row['Name'];?></td>
		    <td><?php echo $row['Price'];?></td> 
		    <td><?php echo $row['Description'];?></td>
		  </tr>
				
		
			

	<?php } ?>
	</table>

	</div>



	

</body>

<? $conn = null; ?>
</html>
