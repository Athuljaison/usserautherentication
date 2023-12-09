<?php
$host = '172.31.22.43';
$username = 'Athul200555976';
$password = '9ROWP0ymjL';
$database = 'Athul200555976';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
