<?php

include "./utility_functions.php";
include "./database_connect.php";

$rules = [
    ["type", "s"],
    ["category", "s"],
    ["post", "s"]
];
if (!validate_parameters($_GET, $rules)) {
    die(json_encode(array("error" => "BAD_PARAMS")));
}

function read_content($type, $database, $post) {
    $statement = $database->prepare("SELECT * FROM ".$type." WHERE name=? LIMIT 1;");
    $statement->bind_param("s", $post);

    if (!$statement->execute()) {
        die(json_encode(["error" => "READ_CONTENT_FAILED"]));
    }

    $result = $statement->get_result();

    if ($result->num_rows !== 1) {
        die(json_encode(["error" => "ERROR_BAD_FILE"]));
    }

    $data = $result->fetch_assoc();
    $statement->close();

    return $data;
}

if ($_GET['type'] === "projects") {
    $path = "../content/projects-content/".$_GET['category']."/".$_GET['post'];

    if (!file_exists($path)) {
        die(json_encode(["error" => "ERROR_BAD_FILE"]));
    }

    $data = read_content("projects", $database, str_replace("-", " ", $_GET['post']));

    $data['number'] = iterator_count(new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS));

    die(json_encode($data));
} else if ($_GET['type'] === "blog") {
    $path = "../content/blog-content/".$_GET['category']."/".$_GET['post']."/main.txt";

    if (!file_exists($path)) {
        die(json_encode(["error" => "ERROR_BAD_FILE"]));
    }

    $data = read_content("blog", $database, str_replace("-", " ", $_GET['post']));

    $data['content'] = file_get_contents($path);

    die(json_encode($data));
} else {
    die(json_encode(["error" => "BAD_PARAMS"]));
}

?>
