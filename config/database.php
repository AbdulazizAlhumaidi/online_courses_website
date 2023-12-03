<?php


$connection = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'database' => 'app2'
];


$mysqli = new mysqli(
    $connection['host'],
    $connection['user'],
    $connection['password'],
    $connection['database']
);

if($mysqli->connect_error){
    die('Error connection to database'. $mysqli->connect_error);
}