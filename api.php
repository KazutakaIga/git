<?php
ini_set('display_errors',1);   //*** error will be displayed in /var/log/httpd/error_log
require('class/database.php');

$db_hostname = "localhost";
$database_name = "seal";
$table_name = "PLAYLIST";

//***
//*** getting path for routing resource target
//*** $_SERVER['SCRIPT_NAME'], /api
//*** $_SERVER['REQUEST_URI']. /api/user/<id>
//*** $path = ["api", "<id>"]
//***
preg_match('|' . dirname($_SERVER['SCRIPT_NAME']) . '/([\w%/]*)|', $_SERVER['REQUEST_URI'], $matches);
$paths = explode('/', $matches[1]);
$id = isset($paths[1]) ? htmlspecialchars($paths[1]) : null;


//***
//*** parsing mysql auth information from requestbody
//***
$db_info = json_decode(file_get_contents('php://input'), true);
echo var_dump($db_info);
echo $db_info["username"] . "\n";
echo $db_info["password"] . "\n";

echo var_dump(isset($paths[1])) . "\n";
echo var_dump(empty($paths[1])) . "\n";
echo var_dump(is_null($paths[1])) . "\n";
echo var_dump($paths[1]) . "\n";

//***
//*** we do NOT allow both resource id and key/value based SELECT or DELETE
//***
if(!empty($paths[1]) && array_key_exists("key", $db_info) && array_key_exists("value", $db_info)){
    echo "You should NOT specify both resource id and where key/value";
    exit (1);
    }

//***
//*** handle routing by http method
//***
switch (strtolower($_SERVER['REQUEST_METHOD']) . ':' . $paths[0]) {
    case 'get:hostname' :

        //***
        //*** + select only one hostname if id is specified, like http://<servername>/hostname/1
        //*** + select all hostname if id is NOT specified, like http://<servername>/hostname
        //***
        if(!empty($paths[1])){
            echo "select by resource id";
            $sql_text = "SELECT * FROM " . $table_name . " WHERE hostname = " . $id;
            }
        else if(array_key_exists("key", $db_info) && array_key_exists("value", $db_info)){
            echo "select by key / value";
            $sql_text = "SELECT * FROM " . $table_name . " WHERE " . $db_info["key"] . " = " . $db_info["value"];
            }
        else{
            echo "select all";
            $sql_text = "SELECT * FROM " . $table_name;
            }
        break;

    case 'post:hostname':
        $sql_text = "INSERT ....... ";
        break;

    case 'delete:hostname':
        if(!empty($paths[1])){
            echo "deleted by resource id";
            $sql_text = "DELETE FROM " . $table_name . " WHERE hostname = " . $id;
            }
        else if(array_key_exists("key", $db_info) && array_key_exists("value", $db_info)){
            echo "deleted by key / value";
            $sql_text = "DELETE FROM " . $table_name . " WHERE " . $db_info["key"] . " = " . $db_info["value"];
            }
        else{
            echo "You need to specify resource id or key / value";
            exit (2);
            }
        break;

    default :
        echo "This method is not Allowed...Supported method is POST, GET. DELETE is only allowed when id is specified";
        exit(3);
        break;
    }

//***
//*** execute sql
//***
$sql = new database();
$sql->exec_sql($db_hostname,
               $db_info["username"],
               $db_info["password"],
               $database_name,
               $sql_text);
?>
