<?php
	if(isset($_SESSION['user'])){
		$wishsql = "SELECT articleId FROM Wishlist WHERE userId = ".$_SESSION['user'];

		//echo "<button id='star'><a href='./wishlist.php?id=".$row['id']."'></a><img src = './gfx/not_starred.png' style='width: 17px;'/></button>";		
		$in_wishlist = false;
		foreach ($conn->query($wishsql) as $wishrow) {
			if($wishrow['articleId'] == $row['id']){
				$in_wishlist = true;
				?><script>document.getElementById("star").style.InnerHTML =""</script><?php
			}
		}
		if($in_wishlist){
			echo "<button id='star'><a href='./wishlist.php?id=".$row['id']."'><img src = './gfx/starred.png' style='width: 17px;'/></a></button>";
		}
		else{
			echo "<button id='star'><a href='./wishlist.php?id=".$row['id']."'><img src = './gfx/not_starred.png' style='width: 17px;'/></a></button>";
		}
	}
?>