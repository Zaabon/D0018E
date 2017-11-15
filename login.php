<?php	
	echo "<table style='border: solid 1px black;'>";
 echo "<tr><th>Email</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 

$servername = "utbweb.its.ltu.se";
$username = "olfjoh-5";
$password = "olfjoh-5";
$dbname = "olfjoh5db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT Email FROM Accounts"); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
        echo $v;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
echo "</table>";






echo $_POST['email'];

$sql = "SELECT * FROM Accounts WHERE Email='".$_POST['email']."'"; 
foreach ($conn->query($sql) as $row) {
        $pwd = $row['pwd'];
}

echo $_POST['pwd'];
if($_POST['pwd'] == $pwd) {
	echo "Ok";
	$_SESSION["user"] = $row['id'];
	echo "ID: ".$_SESSION["user"];
	
}
else {
	echo "Login failed";
	header('Location: ' . $_SERVER['HTTP_REFERER']."?error=login");
}

echo "<br><a href='".$_SERVER['HTTP_REFERER']."'>Go back</a>";

$conn = null;


//header('Location: ' . $_SERVER['HTTP_REFERER']);

?>