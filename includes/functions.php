<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'school';


function authStudent($id)
{
    require_once "db.php";

    $sql = "SELECT * FROM `students` WHERE id = $id";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $class = $row['class'];
        $actualScore = $row['score'];

        setcookie("id", $id, time() + 3600, "/");
        setcookie("fname", $firstname, time() + 3600, "/");
        setcookie("lname", $lastname, time() + 3600, "/");
        setcookie("class", $class, time() + 3600, "/");
        setcookie("score", $actualScore, time() + 3600, "/");
        setcookie("error", "Сіз сәтті түрде кірдіңіз!", time() + 30, "/");
        header("Location: ./student/index.php");
        exit();
    } else {
        setcookie("error", "Сіздің ID табылмады!", time() + 30, "/");
        header("Location: ./index.php");
        exit();
    }
}

function authAdmin($pass)
{
    global $host;
    global $username;
    global $password;
    global $database;
    $mysqli = new mysqli($host, $username, $password, $database);

    $sql = "SELECT * FROM `admins` WHERE pass = '$pass'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pass = $row['pass'];

        setcookie("admin", "yes", time() + 3600, "/");
        setcookie("error", "Сіз сәтті түрде кірдіңіз!", time() + 30, "/");
        header("Location: ./index.php");
        exit();
    } else {
        setcookie("error", "Құпиясөз қате!", time() + 30, "/");
        header("Location: ./login.php");
        exit();
    }
}

function exitCookie()
{
    setcookie("id", '', time() + 3600, "/");
    setcookie("fname", "", time() - 3600, "/");
    setcookie("lname", "", time() - 3600, "/");
    setcookie("class", "", time() - 3600, "/");
    setcookie("score", "", time() - 3600, "/");
    header("Location: ../index.php");
    exit();
}

function exitAdmin()
{
    setcookie("admin", "", time() - 3600, "/");
    header("Location: ../admin/login.php");
    exit();
}
function getGoods()
{
    require_once "db.php";

    $sql = "SELECT * FROM `goods`";
    $resultt = $mysqli->query($sql);
    if ($resultt) {
        return $resultt;
    }
}
function buyGoods($id)
{
    global $host;
    global $username;
    global $password;
    global $database;
    $mysqli = new mysqli($host, $username, $password, $database);

    $sql = "SELECT * FROM goods WHERE id = $id";
    $result = $mysqli->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $GName = $row['name'];
        $GPrice = $row['price'];
        $GPin = $row['pin'];
    }
    $userid = $_COOKIE['id'];
    if ($_COOKIE['score'] >= $GPrice) {
        $file = '../esp32-pin.json';
        $newscore = $_COOKIE['score'] - $GPrice;

        $sql = "UPDATE `students` SET score = $newscore WHERE id=$userid";
        $result = $mysqli->query($sql);
        if ($result) {
            file_put_contents($file, json_encode(["value" => $GPin]));
            sleep(1);
            file_put_contents($file, json_encode(["value" => 0]));
            setcookie("score", $newscore, time() + 3600, "/");
            setcookie("error", "Сіз $GName cәтті түрде сатып алдыңыз!", time() + 30, "/");
            header("Location: ../student/shop.php");
            exit();
        }
    } else {
        $price = $GPrice - $_COOKIE['score'];
        setcookie("error", "Сіз $GName сатып алу үшін $price балл жетпейді!", time() + 30, "/");
        header("Location: ../student/shop.php");
        exit();
    }


}
function getTypes()
{
    global $host;
    global $username;
    global $password;
    global $database;
    $mysqli = new mysqli($host, $username, $password, $database);
    if ($mysqli->connect_error) {
        die('Ошибка подключения к базе данных: ' . $mysqli->connect_error);
    }
    $sql = "SELECT * FROM `questions_types`";
    $result = $mysqli->query($sql);
    return $result;
}
function gostart($id)
{
    require_once "db.php";

    $sql = "SELECT * FROM questions_types WHERE id=$id";
    $result = $mysqli->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $subject = $row['name'];
        setcookie("subject", $subject, time() + 3600, "/");
        header("Location: ../test.php?s=$subject");
    }
}

function gohome($score)
{
    setcookie("error", "Cіз тесттен $score балл жинадыңыз!", time() + 30, "/");
    setcookie("correct_count", "", time() + 3600, "/");
    header("Location: ./student/index.php");
    exit();
}
function getCards()
{
    global $host;
    global $username;
    global $password;
    global $database;
    $mysqli = new mysqli($host, $username, $password, $database);

    if ($mysqli->connect_error) {
        die('Ошибка подключения к базе данных: ' . $mysqli->connect_error);
    }
    $sql = "SELECT * FROM `cards`";
    $result = $mysqli->query($sql);
    return $result;
}
function DeleteCard($id)
{
    require_once "db.php";

    $sql = "DELETE FROM cards WHERE id=$id";
    $result = $mysqli->query($sql);
    if ($result) {
        setcookie("error", "Карточка сәтті жойылды!", time() + 30, "/");
        header("Location: ../admin/cards.php");
        exit();
    } else {
        setcookie("error", "Карточка жою сәтсіз өтті", time()+30, "/");
        header("Location: ../admin/cards.php");
        exit();
    }
}
?>
