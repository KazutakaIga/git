<?php
ini_set('display_errors',1);

class database{

    public function exec_sql($target_host,
                             $user,
                             $password,
                             $target_db,
                             $sql_text){

        $link = mysql_connect($target_host, $user, $password); ### �����ς���
        if (!$link) die('Failed to connect target database : '.mysql_error());

        $db_selected = mysql_select_db('seal', $link);          ### �����ς���
        if (!$db_selected) die('unable to find selected database : '.mysql_error());

        $result = mysql_query($sql_text);
        if (!$result) die('query has been failed : '.mysql_error());

        $data = null;

        if(preg_match('/SELECT/i',$sql_text)){
            while ($row = mysql_fetch_assoc($result)) {
                $data[] = array(
                            'userid'      => $row["USERID"],      ### �����ς���
                            'datapath'    => $row["DATAPATH"],    ### �����ς���
                            'title'       => $row["TITLE"],       ### �����ς���
                            'comment'     => $row["COMMENT"],     ### �����ς���
                            'create_date' => $row["CREATE_DATE"], ### �����ς���
                            'playcount'   => $row["PLAYCOUNT"],   ### �����ς���
                            'successcount'=> $row["SUCCESSCOUNT"] ### �����ς���
                            );
                }
            }
        echo json_encode($data,
                         JSON_NUMERIC_CHECK);
        mysql_close($link);
        }
    }

#$sql = new database();
#$sql_text = "SELECT * FROM PLAYLIST";
#$sql->exec_sql("localhost",
#               "root",
#               "dile6245",
#               "seal",
#               $sql_text);
?>