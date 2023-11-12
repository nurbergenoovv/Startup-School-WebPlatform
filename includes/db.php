<?php

$host = 'srv-pleskdb39.ps.kz:3306';
$username = 'clickmek_school';
$password = 'Aktau7292';
$database = 'clickmek_school';

$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_error) {
    die('Ошибка подключения к базе данных: ' . $mysqli->connect_error);
}
?>