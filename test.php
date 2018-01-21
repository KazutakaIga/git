<?php
ini_set('display_errors',1);
require('class/database.php');

$db_hostname = "localhost";
$database_name = "seal";
$table_name = "PLAYLIST";
$username = "root";
$password = "";

$sql = new database();
$sql_text = "SELECT * FROM PLAYLIST";
$sql->exec_sql($db_hostname,
               $username,
               $password,
               $database_name,
               $sql_text);
?>
