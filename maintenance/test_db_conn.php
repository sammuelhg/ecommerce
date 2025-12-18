<?php
$host = '127.0.0.1';
$port = 3307;
$user = 'root';
$pass = '';
$db = 'ecommerce_hp';

$mysqli = new mysqli($host, $user, $pass, $db, $port);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

echo 'Success... ' . $mysqli->host_info . "\n";

$result = $mysqli->query("SHOW TABLES");
echo "Tables in database:\n";
while ($row = $result->fetch_array()) {
    echo $row[0] . "\n";
}

$mysqli->close();
?>
