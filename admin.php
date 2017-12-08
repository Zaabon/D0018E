<!doctype html>
<html>
<head>
<?php include 'connect.php';


// Check if admin
if(!isset($_SESSION['user'])) {
	header('Location: index.php'); 
}

$query = "SELECT isAdmin FROM Accounts WHERE id =".$_SESSION['user'];
$query = $conn->prepare($query);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);

if(!$result['isAdmin']) {
	header('Location: index.php'); 
}
?>



<meta charset="utf-8">
<title>Test</title>

<link href="stylesheat.css" rel="stylesheet" type="text/css">
</head>

<body style="background-color:#DDDDDD;">
	<div id="wrapper">
		<div id="content">
			<?php 
			if(isset($_GET['id'])) {
				$sql = "SELECT * FROM Articles WHERE id=".$_GET['id'];
				$sql = $conn->prepare($sql);
				$sql->execute();
				$article = $sql->fetch(PDO::FETCH_ASSOC);
				
				$sql = "SELECT * FROM Tags WHERE articleID=".$article['id'];
				
				$tags = "";
				foreach ($conn->query($sql) as $row) {
					$tags .= $row['tag'].",";
				}
				$tags = chop($tags, ",");
			
				echo '<b>Edit '.$article['name'].'</b>
					<form action="/~olfjoh-5/adminFunctions.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="'.$_GET['id'].'">
				  	Name*:<br>
				 	 <input type="text" name="name" value="'.$article['name'].'" required><br>
				 	Price*:<br>
				 	<input type="number" min=0 name="price" value="'.$article['price'].'" required><br>
				 	Stock*:<br>
				 	<input type="number" name="stock" value="'.$article['stock'].'" required><br>
					Category*:<br>
				 	<input type="text" name="category" value="'.$article['category'].'"><br>
				 	Tags (seperate with comma):<br>
				 	<input type="text" name="tags" value="'.$tags.'" multiple><br>
				 	Description*:<br>
				 	<textarea rows="5"  name="description" required>'.$article['description'].'</textarea><br>
					<input type="submit" name="edit" value="Save" />
				</form>';
			}
					
			?>
			
			<br><br>
			<b>Add new article</b>
			<form action="/~olfjoh-5/adminFunctions.php" method="post" enctype="multipart/form-data">
				  	Name*:<br>
				 	 <input type="text" name="name" required><br>
				 	Price*:<br>
				 	<input type="number" min=0 name="price" required><br>
				 	Stock*:<br>
				 	<input type="number" name="stock" required><br>
					Category*:<br>
				 	<input type="text" name="category" required><br>
				 	Tags (seperate with comma):<br>
				 	<input type="text" name="tags" multiple><br>
				 	Description*:<br>
				 	<textarea rows="5"  name="description" required></textarea><br>
				 	Image:<br>
				 	<input type="file" name="image"><br>
					<input type="submit" name="create" value="Create" />
				</form>
		</div>
	</div>
</body>

<?php $conn = null; ?>
</html>

