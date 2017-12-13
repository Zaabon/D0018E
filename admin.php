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
			echo "ADMIN";
		}
		?>



		<meta charset="utf-8">
		<title>FunProducts.se</title>

		<link href="stylesheet.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<div id="header">
			<?php include("header_template.php");?>
		</div>
		<div id="content">
		
			<table>
				<td style="vertical-align: text-top; padding-left: 10px;">
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
						echo "<a href='./product.php?id=".$_GET['id']."'>Go back to article</a>";
					}
					?>
				</td>
				<td style="vertical-align: text-top; padding-top: 10px;">
					<?php
		
						if( ! empty($_SESSION['image_error_msg']))
						{
						    echo "<p style='color: red;'>".$_SESSION['image_error_msg']."</p>";
						    unset($_SESSION['image_error_msg']);
						}
					?>
					<b>Add new article</b>
					<form action="/~olfjoh-5/adminFunctions.php" method="post" enctype="multipart/form-data">
					  	Name*:<br>
					 	 <input type="text" name="name" required><br>
					 	Price*:<br>
					 	<input type="number" min=0 name="price" required><br>
					 	Stock*:<br>
					 	<input type="number" name="stock" required><br>
						Category*:<br>
						<input type="text" list="category" name="category"/>
						<datalist required id="category">
							<?php foreach($catArr as $cat){
								echo "<option value='".$cat."'>".$cat."</option>";
							}?>
						</datalist><br>
					 	<!--<input type="text" name="category" required><br>-->
					 	Tags (seperate with comma):<br>
					 	<input type="text" name="tags" multiple><br>
					 	Description*:<br>
					 	<textarea rows="5"  name="description" required></textarea><br>
					 	Image:<br>
					 	<input type="file" name="image"><br>
						<input type="submit" name="create" value="Create" />
					</form>
				</td>
			</table>
		</div>
	</body>

	<?php $conn = null; ?>
</html>

