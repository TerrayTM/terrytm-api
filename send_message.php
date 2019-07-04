<?php

include "./utility_functions.php";

$request = json_decode(file_get_contents("php://input"), true);

$rules = [
    ["name", "s"],
    ["email", "e"],
    ["message", "s"]
];
if (!validate_parameters($request, $rules)) {
    die(json_encode(array("error" => "BAD_PARAMS")));
}

if (!mail("contact@terrytm.com", "Message", "Name: ".$request['name']."\nEmail: ".$request['email']."\n\nMessage:\n".$request['message'], "From: ".$request['email'])) {
    die(json_encode(array("error" => "MAIL_FAILED")));
}

die(json_encode(array("status" => "SUCCESS")));

?>