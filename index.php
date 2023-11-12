<?php
require_once "./includes/functions.php";

if (isset($_POST['auth'])) {
    $id = $_POST['studentid'];
    authStudent($id);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BilimBILL - кіру</title>
    <link rel="stylesheet" href="./style/main.css">
    <link rel="stylesheet" href="./style/page-login.css">
    <link rel="stylesheet" href="./style/error.css">
    <link rel="shortcut icon" href="./icon.jpeg" />
    <style>
        .loading {
            position: fixed;
            width: 100vw;
            height: 100vh;
            background-color: grey;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .loader {
            width: 48px;
            height: 48px;
            display: inline-block;
            position: relative;
            z-index: 99;
        }

        .loader::after,
        .loader::before {
            content: '';
            box-sizing: border-box;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 4px solid #FFF;
            position: absolute;
            left: 0;
            top: 0;
            animation: animloader 2s linear infinite;
        }

        .loader::after {
            animation-delay: 1s;
        }

        @keyframes animloader {
            0% {
                transform: scale(0);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 0;
            }
        }
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
        setcookie("error", "", time() - 9600, "/"); // Вывод сообщения об ошибке
    }
    ?>
    <div class="loading" id="preloader"><span class="loader"></span></div>
    <script>
        window.onload = function () {
            var preloader = document.getElementById('preloader');
            preloader.style.display = 'none';
        }
        </script>

    <form action="" method="post">
        <h1>BilimBILL - білім алып жарысайык</h1>
        <p>*Жұмысты бастау үшін авторизациядан өтіңіз</p>
        <input placeholder="Жеке ID" name="studentid" type="number" />
        <button name="auth">КІРУ</button>
    </form>
    
</body>

</html>