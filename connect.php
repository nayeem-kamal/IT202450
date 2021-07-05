<?php
$servername = "db.ethereallab.app";
$username = "root";
$password = "r5fQzsyOzYsN";
$dbname = "nhk6";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    header("location:connection_error.php?error=$conn->connect_error");
    die($conn->connect_error);
}
?>
