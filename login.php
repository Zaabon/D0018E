<?php	
	
include 'connect.php';


if(isset($_POST['logout'])) {
	header('Location: ./index.php');
	echo "Log out";
	$_SESSION['user'] = NULL;
	
}
else if(isset($_POST['change_pwd'])){
	echo "Change pwd<br>";
	echo $_POST['old_pwd'].'<br>';
	echo $_POST['new_pwd'].'<br>';
	
	$sql = "SELECT pwd FROM Accounts where id= ".$_SESSION['user'];
	
	foreach ($conn->query($sql) as $row) {
		    //if($row["pwd"] == $_POST['old_pwd']){
		    echo "OLD: ".$_POST['old_pwd']." pwd: ".$row["pwd"]." verify: ".password_verify($_POST['old_pwd'], $row["pwd"]);
		    if(password_verify($_POST['old_pwd'], $row["pwd"])){

		    	$changesql = "UPDATE Accounts SET pwd = '".password_hash($_POST['new_pwd'], PASSWORD_DEFAULT)."' WHERE id = ".$_SESSION['user'];
		    	$stmt = $conn->prepare($changesql);
			$stmt->execute();
		    }
		    else{
		    	$_SESSION['login_error_msg'] = "Sorry, your old password is wrong. Please try again.";
		    }
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else {
	echo $_POST['email'];

	$sql = "SELECT * FROM Accounts WHERE Email='".$_POST['email']."'"; 
	foreach ($conn->query($sql) as $row) {
		    $pwd = $row['pwd'];
	}

	echo $_POST['pwd'];
	//if($_POST['pwd'] == $pwd) {
	if(password_verify($_POST['pwd'], $pwd)){
		echo "<br>Ok<br>";
		$_SESSION['user'] = $row['id'];
		echo "ID: ".$_SESSION["user"];
	
	}
	else {
		echo "Login failed";
		//header('Location: ' . $_SERVER['HTTP_REFERER']."?error=login");
		
		$_SESSION['login_error_msg'] = "Sorry, your email or password was incorrect. Please try again.";
	}

	echo "<br><a href='".$_SERVER['HTTP_REFERER']."'>Go back</a>";
	
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
$conn = null;




?>