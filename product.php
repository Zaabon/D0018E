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
		<h1>
      <?php
			  $sql = "SELECT name FROM Articles where name='".$_POST['name']."'";
			  $row = $conn->query($sql);
			
			  foreach ($conn->query($sql) as $r){
				  echo $r[0];
			  }
		  ?>
		</h1>
		<p>
			Price:
			<?php
			  $sql = "SELECT price FROM Articles where name='".$_POST['name']."'";
			  $row = $conn->query($sql);
			
			  foreach ($conn->query($sql) as $r){
				  echo $r[0];
			  }
		  ?>
		</p>
		<p>
			In stock:
			<?php
			  $sql = "SELECT stock FROM Articles where name='".$_POST['name']."'";
			  $row = $conn->query($sql);
			
			  foreach ($conn->query($sql) as $r){
				  echo $r[0];
			  }
		  ?>
		</p>
		<p>
			Description:
			<?php
			  $sql = "SELECT description FROM Articles where name='".$_POST['name']."'";
			  $row = $conn->query($sql);
			
			  foreach ($conn->query($sql) as $r){
				  echo $r[0];
			  }
		  ?>
		</p>
</body>

</html>
