<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case "POST":
    include "./send_message.php";
	break;
  case "GET":
    if (isset($_GET['type'])) {
        if ($_GET['type'] === "all") {
            include "./get_data.php";
        } else {
            if (isset($_GET['list'])) {
                include "./list_items.php";
            } else {
                include "./get_content.php";
            }
        }
    } else {
        die(json_encode(array("error" => "INVALID_REQUEST")));
    }
    break;
  default:
    die(json_encode(array("error" => "INVALID_REQUEST")));
    break;
}

?>