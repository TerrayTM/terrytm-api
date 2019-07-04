<?php

DEFINE ("DATABASE_HOST", "******");
DEFINE ("DATABASE_NAME", "******");
DEFINE ("DATABASE_USER", "******");
DEFINE ("DATABASE_PASSWORD", "******");

$database = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);

if ($database->connect_error) {
    die(json_encode(array("error" => "DATABASE_CONNECTION_FAILED")));
}

?>
