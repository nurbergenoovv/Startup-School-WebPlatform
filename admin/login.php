<?php
require_once "../includes/functions.php";

if (isset($_POST['auth'])) {
    $password = $_POST['pass'];
    authAdmin($password);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/error.css">
    <title>LOGIN</title>
    <style>
        body { 
            width: 100vw; 
            height: 100vh; 
            display: grid; 
            place-items: center; 
            font-family: 'Courier New', Courier, monospace; 
            user-select: none; 
        } form { 
            padding: 20px; 
            border-radius: 11px; 
            border: solid 2px black; 
            display: flex; 
            flex-direction: column; 
        }  input, button { 
            padding-block: 7px; 
            font-weight: 600; 
        } input { 
            margin-block: 7px; 
            font-size: 15px; 
            padding-inline: 10px; 
            border-radius: 10px 10px 3px 3px; 
            border: black 2px solid; 
        } h1 { 
            margin: 0; 
        } button { 
            border-radius: 3px 3px 10px 10px; 
            color: white; 
            background: black;  } 
        .error-container {
            position: fixed;
            bottom: -100px;
            right: 25px;
            background-color: #f1f1f1;
            z-index: 99;
            padding: 10px 20px;
            max-width: 300px;
            border-radius: 5px 5px 0 0;
            animation: ErrorIn 5s ease-in-out;
            border-bottom: 3px green solid;
            /* Анимация вылета */
        }

        .error-container p {
            font-size: 22px;
            text-align: center;
            color: black;
        }

        /* Стили для блока с сообщением об ошибке */
        .error-message {
            font-size: 22px;
        }

        @keyframes ErrorIn {
            0% {
                bottom: -100px;
            }

            15% {
                bottom: 25px;
            }

            85% {
                bottom: 25px;
            }

            100% {
                bottom: -100px;
            }
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
    <form action="" method="post">
        <label for="newpass">Құпиясөз:</label>
        <input type="password" name="pass">
        <button type="submit" name="auth">Кіру</button>
    </form>
</body>

</html>