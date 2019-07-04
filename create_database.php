<?php

include "./database_connect.php";

$database->query("CREATE TABLE projects (
    id int(10) not null primary key auto_increment,
    name varchar(255) not null,
    type varchar(64) not null,
    date date not null,
    creator varchar(64) not null,
    description varchar(2048) not null,
    technology varchar(255) not null,
    link varchar(64),
    tag varchar(64) not null
);");

$database->query("CREATE TABLE blog (
    id int(10) not null primary key auto_increment,
    name varchar(255) not null,
    type varchar(64) not null,
    date date not null,
    tag varchar(64) not null
);");

?>
