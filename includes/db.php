<?php

$host = 'localhost';
$username = 'root';
$password = ' ';
$database = 'school';

$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_error) {
    die('Ошибка подключения к базе данных: ' . $mysqli->connect_error);
}
?>
