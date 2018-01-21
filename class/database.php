<?php
ini_set('display_errors',1);

class database{

    public function exec_sql($target_host,
                             $user,
                             $password,
                             $target_db,
                             $sql_text){

        $link = mysql_connect($target_host, $user, $password);
        if (!$link) die('Failed to connect target database : '.mysql_error());

        $db_selected = mysql_select_db($target_db, $link);
        if (!$db_selected) die('unable to find selected database : '.mysql_error());

        $result = mysql_query($sql_text);
        if (!$result) die('query has been failed : '.mysql_error());

        $data = null;

        if(preg_match('/SELECT/i',$sql_text)){
            while ($row = mysql_fetch_assoc($result)) {
                $data[] = array(
                            'userid'      => $row["USERID"],      ### ここ変える
                            'datapath'    => $row["DATAPATH"],    ### ここ変える
                            'title'       => $row["TITLE"],       ### ここ変える
                            'comment'     => $row["COMMENT"],     ### ここ変える
                            'create_date' => $row["CREATE_DATE"], ### ここ変える
                            'playcount'   => $row["PLAYCOUNT"],   ### ここ変える
                            'successcount'=> $row["SUCCESSCOUNT"] ### ここ変える
                            );
                }
            }
        echo json_encode($data,
                         JSON_NUMERIC_CHECK);
        mysql_close($link);
        }
    }

?>
