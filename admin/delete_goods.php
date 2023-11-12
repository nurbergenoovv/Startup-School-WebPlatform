<?php
if (!isset($_COOKIE['admin'])) {
    header("Location: ./login.php");
    exit();
}
require_once('../includes/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM goods WHERE id = $id";
    $result = $mysqli->query($query);
    if ($result) {
        setcookie("error", "Товар жойылды", time() + 30, "/");
        header("Location: ./goods.php");
        exit();
    }
}
?>