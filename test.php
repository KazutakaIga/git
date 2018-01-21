<?php
ini_set('display_errors',1);
require('class/database.php');

$sql = new database();
$sql_text = "SELECT * FROM PLAYLIST";
$sql->exec_sql("localhost",
               "root",
               "dile6245",
               "seal",
               $sql_text);
?>