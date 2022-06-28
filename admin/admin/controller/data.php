<?php
include "../class/post.php";
include "../class/config.php";
switch ($_POST['request_Type']) {
    case "ADD": {
            $postobj = new POST_DATA(config::getConn());
            $result = $postobj->insert_PostData($_POST, $_FILES);
            if ($result['result'] == "1") {
                echo "Data Added Successfully";
            } else {
                echo "0";
            }
            break;
        }
    case "UPDATE": {
            $postobj = new POST_DATA(config::getConn());
            $result = $postobj->update_PostData($_POST, $_FILES);
            print_r($result);
            break;
        }
    case "GET": {
            $postobj = new POST_DATA(config::getConn());
            $result = $postobj->getAllData();
            print_r($result);
            break;
        }
    case "showForm": {
            $postobj = new POST_DATA(config::getConn());
            $result = $postobj->showForm($_POST);
            print_r($result);
            break;
        }
    case "DEl": {
            $postobj = new POST_DATA(config::getConn());
            $result = $postobj->del_Post("event", "id", $_POST['id']);
            print_r($result);
            break;
        }
    case "FIND": {
            $postobj = new POST_DATA(config::getConn());
            $result = $postobj->findEvent($_POST);
            print_r($result);
            break;
        }
}
