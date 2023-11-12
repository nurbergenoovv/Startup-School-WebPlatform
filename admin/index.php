<?php
if (!isset($_COOKIE['admin'])) {
    header("Location: ./login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/error.css">
    <title>ADMIN PANEL</title>
    <style>
        body {
            background-color: #cdcdcd;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            row-gap: 15px;
            font-family: Arial;
        }

        a {
            text-decoration: none;
            width: 400px;
            padding-block: 10px;
            text-align: center;
            background-color: #333;
            color: white;
            transition: .5s all ease-in-out;
        }

        a:hover {
            background-color: rgba(255, 255, 255, 0.5);
            color: black;
        }
        .center{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            row-gap: 15px;
            margin-top: 15%;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_COOKIE['error'])) {
        $error = $_COOKIE['error'];
        echo "<div class='error-container'>
        <div class='error-message'>$error</div>
        </div>";
        setcookie("error", "", time() - 3600, "/"); // Вывод сообщения об ошибке
    }
    ?>
    <div class="center">
        <a href="./students.php" class="btn-style">Оқушылар тізімі</a>
        <a href="./questions.php" class="btn-style">Сұрақ тізімі</a>
        <a href="./question_types.php" class="btn-style">Сұрақ катергория тізімі</a>
        <a href="./goods.php" class="btn-style">Товарлар тізімі</a>
        <a href="./cards.php" class="btn-style">Карточкалар тізімі</a>
        <a href="./exit.php" class="btn-style">Шығу</a>
    </div>
</body>

</html>