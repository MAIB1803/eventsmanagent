<?php
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = strval($data);
    return $data;
}
function check_img($name){
    $filename="";
    $extension = strtolower(pathinfo($name,PATHINFO_EXTENSION));

    if($extension =="jpg" || $extension =="png" ||$extension =="jpeg" ||$extension =="gif"){

        $filename=time().".".$extension;
        return  $filename;

    }else{
        return "0";
    }
}
function noOfPost($conn,$table){
    $output = "";
    $sql = "SELECT COUNT(*) as count FROM `$table`";
    $res = mysqli_query($conn,$sql);
    if(mysqli_num_rows($res)>0){
        $f = mysqli_fetch_assoc($res);
        $output = $f['count'];
    }else{
        $output = "0";
    }
    return $output;
}
