<?php

class db_DATA
{
    private $conn;
    function __construct($conn)
    {
        $this->conn = $conn;
    }
    function sql_QUERY($sql)
    {
        $res = mysqli_query($this->conn, $sql);
        return $res;
    }
    function make_SQL($data, $type)
    {
        // INSERT ,UPDATE ,DELETE => type
        $sql = "";
        switch ($type) {
            case "INSERT": {
                    $sql = "INSERT INTO `";
                    $sql = $sql . $data['table'] . "` ";
                    $sql_keys = "(";
                    $sql_val = "(";
                    $count = 0;
                    foreach ($data as $key => $val) {
                        if ($key != "table") {
                            $sql_keys .= "`" . $key . "`";
                            $sql_val .= "'" . $val . "'";
                        }
                        //adding `,`
                        if ($count < count($data) - 1 && $key != "table") {
                            $sql_keys .= ", ";
                            $sql_val .= ", ";
                        }
                        $count++;
                    }
                    $sql_keys .= ")";
                    $sql_val .= ")";
                    $sql .= $sql_keys . " VALUES " . $sql_val;
                    break;
                }
            case "FETCH": {
                    $sql = "SELECT * FROM `";
                    $sql = $sql . $data['table'] . "` ";
                    break;
                }
            case "UPDATE": {
                    $sql = "UPDATE `";
                    $sql = $sql . $data['table'] . "` SET ";
                    $sql_keys = "";
                    $sql_val = "";
                    $sql_set = "";
                    $count = 0;
                    foreach ($data as $key => $val) {
                        if ($key != "table" && $key != "id") {
                            $sql_keys .= "`" . $key . "`";
                            $sql_val .= "'" . $val . "'";
                        }
                        //set
                        if ($key != "table" && $key != "id") {
                            $sql_set .= $sql_keys . " = " . $sql_val;
                        }
                        $count++;
                        //adding `,`
                        if ($count < count($data) - 1 && $key != "table" && $key != "id") {
                            $sql_set .= ",";
                            $sql_keys = "";
                            $sql_val = "";
                        }
                    }

                    $sql .= $sql_set . " WHERE id = '" . $data['id'] . "'";
                    break;
                }
        }
        return $sql;
    }

    // INSERT INTO `users` (`id`, `ss`, `ss1`) VALUES (NULL, '123', '{}');
    function insert_Data($data)
    {
        $sql = $this->make_SQL($data, "INSERT");
        $res = $this->sql_QUERY($sql);
        return $res;
    }
    function update_Data($data)
    {
        $sql = $this->make_SQL($data, "UPDATE");
        $res = $this->sql_QUERY($sql);
        return $res;
    }

    function fetch_Data($table, $val, $key)
    {
        $sql = "SELECT * FROM `$table` WHERE `$key` = '$val' order by id DESC";
        $res = $this->sql_QUERY($sql);
        return $res;
    }
    function del_Data($table, $key, $val)
    {
        $sql = "DELETE FROM `$table` WHERE `$key` = '$val'";
        $res = $this->sql_QUERY($sql);
        return $res;
    }
}
