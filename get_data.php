<?php

include "./database_connect.php";

function read_data($name, $database) {
    $data = [];
    
    if ($query = $database->query("SELECT name, date, type FROM ".$name." ORDER BY date DESC;")) {
        while ($row = $query->fetch_assoc()) {
            if (!isset($data[$row['type']])) {
                $data[$row['type']] = [];
            }

            $data[$row['type']][] = [
                "label" => $row['name'],
                "to" => "/".$name."/".str_replace(" ", "-", $row['type'])."/".str_replace(" ", "-", $row['name'])
            ];
        }
    } else {
        die(json_encode(array("error" => "DATABASE_ACCESS_FAILED")));
    }

    $query->free();

    return $data;
}

$blogData = read_data("blog", $database);

$blogTypes = scandir("../content/blog-content");
for ($i = 0; $i < count($blogTypes); ++$i) {
    if ($blogTypes[$i] !== "." && $blogTypes[$i] !== "..") {
        if (!isset($blogData[$blogTypes[$i]])) {
            $blogData[$blogTypes[$i]] = [];
        }
    }
}

die(json_encode([
    "projectsData" => read_data("projects", $database),
    "blogData" => $blogData
]));

?>
