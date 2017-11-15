<?php

$servername = "utbweb.its.ltu.se";
$username = "olfjoh-5";
$password = "olfjoh-5";
$dbname = "olfjoh5db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
session_start();
?>