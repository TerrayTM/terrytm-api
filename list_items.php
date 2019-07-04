<?php

include "./utility_functions.php";
include "./database_connect.php";

$rules = [
    ["type", "s"],
    ["list", "s"]
];
if (!validate_parameters($_GET, $rules)) {
    die(json_encode(array("error" => "BAD_PARAMS")));
}

$data = [];

if ($_GET['type'] === "projects") {
    if ($query = $database->query("SELECT name, type, date, description FROM projects ORDER BY date DESC;")) {
        while ($row = $query->fetch_assoc()) {
            $data[] = [
                "name" => $row['name'],
                "type" => $row['type'],
                "date" => $row['date'],
                "description" => $row['description'],
                "link" => "/projects/".str_replace(" ", "-", $row['type'])."/".str_replace(" ", "-", $row['name'])
            ];
        }
    } else {
        die(json_encode(array("error" => "DATABASE_ACCESS_FAILED")));
    }

    $query->free();
} else if ($_GET['type'] === "blog") {
    if ($query = $database->query("SELECT name, type, date FROM blog ORDER BY date DESC;")) {
        while ($row = $query->fetch_assoc()) {
            $data[] = [
                "name" => $row['name'],
                "type" => $row['type'],
                "date" => $row['date'],
                "link" => "/blog/".str_replace(" ", "-", $row['type'])."/".str_replace(" ", "-", $row['name'])
            ];
        }
    } else {
        die(json_encode(array("error" => "DATABASE_ACCESS_FAILED")));
    }

    $query->free();
} else {
    die(json_encode(array("error" => "BAD_PARAMS")));
}

die(json_encode($data));

?>