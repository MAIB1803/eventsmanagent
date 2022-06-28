<?php
// error_reporting(0);
//db - configuration
class config
{
    public static function getConn()
    {
        $db = mysqli_connect("localhost", "root", "", "mannu") or die("db not found");
        return $db;
    }
}
