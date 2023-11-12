<?php
if (!isset($_COOKIE['id'])) {
    header("Location: ../index.php");
    exit();
}

require_once "../includes/functions.php";
require_once "../includes/db.php";

if (isset($_POST['buy'])) {
    $id = $_POST['id'];
    buyGoods($id);
}

if (isset($_POST['logout'])) {
    exitCookie();
}

$result = getTypes();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BilimBIL - басты бет</title>
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./page-index.css">
    <link rel="shortcut icon" href="../icon.jpeg" />
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
    </style>
    <style>
        .rightForm {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .shop {
            width: 100%;
            background-image: url('../images/background/index-bg-noo.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: grid;
            place-items: center;
            color: white;
            padding: 0;
        }

        .shopcont {
            background: white;
            padding: 20px;
            border-radius: 11px;
            min-width: 85vw;
            height: auto;
            min-height: 220px;
            display: flex;
            justify-content: center;
            color: black;
            gap: 20px;
        }

        .shop-item {
            padding: 20px;
            border-radius: 11px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            border: solid 2px gray;
            width: 150px;
            align-items: center;
        }

        .closer {
            justify-content: center;
            font-weight: 700;
            color: red;
            border-color: red;
            transition: all .3s;
        }

        .shop-item:hover {
            background: #eee;
        }

        .buy-btn {
            font-family: Arial;
            font-size: 16px;
            font-weight: 500;
            padding: 5px 7px;
            color: black;
            border: 2px solid black;
            border-radius: 11px;
            background-color: transparent;
            transition: .4s all ease-in-out;
        }

        .buy-btn:hover {
            background-color: black;
            color: white;
        }

        .error-container {
            position: fixed;
            bottom: -100px;
            right: 39%;
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
        setcookie("error", "", time() - 30, "/"); // Вывод сообщения об ошибке
    }
    ?>
    <nav id="navbar">
        <span class="iconOfSite">
            <span class="lastName">
                <?php echo $_COOKIE['lname']; ?>
            </span>
            <span class="firstName">
                <?php echo $_COOKIE['fname']; ?>
            </span>
            <span class="firstName">
                <?php echo $_COOKIE['class']; ?>
            </span>
        </span>
        <div class="links">
            <div class="dropdown">
                <a href="./index.php" class="nav-links">Тестілеу</a>
                <div class="dropdown-content">
                    <?php if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()): ?>
                            <a href="./startTest.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a>
                        <?php endwhile;
                    } else {
                        echo "<p>Сурак категориялары алы косылмады</p>";
                    } ?>
                </div>
            </div>
            <a href="./shop.php" class="nav-links opener">Онлайн дүкен</a>
        </div>
        <div class="rightForm">
            <span class="iconOfSite pts">
                <?php echo $_COOKIE['score']; ?>
            </span>
            <span class="iconOfSite">Балл</span>
            <form action="" method="post"><button name="logout">Шығу</button></form>

        </div>
    </nav>

    <header class="firstSection shop">
        <div class="shopcont">
            <?php
            $host = 'srv-pleskdb39.ps.kz:3306';
            $username = 'clickmek_school';
            $password = 'Aktau7292';
            $database = 'clickmek_school';

            $mysqli = new mysqli($host, $username, $password, $database);
            if ($mysqli->connect_error) {
                die('Ошибка подключения к базе данных: ' . $mysqli->connect_error);
            }
            $sql = "SELECT * FROM `goods`";
            $reult = $mysqli->query($sql);

            if ($reult) {
                while ($row = $reult->fetch_assoc()) {
                    $name = $row['name'];
                    $price = $row['price'];
                    $id = $row['id'];

                    echo '
                <div class="shop-item">
                    <span class="shop-name">' . $name . '</span>
                    <span class="shop-price">' . $price . '</span>
                    <form action="./shop.php" method="post">
                        <input type="hidden" name="id" value="' . $id . '">
                        <button type="submit" name="buy" class="buy-btn">Сатып алу</button>
                    </form>
                </div>';
                }
            } else {
                echo "Goods not found!";
            }
            ?>
        </div>
    </header>
    <div class="loading" id="preloader"><span class="loader"></span></div>
    <script>
        window.onload = function () {
            var preloader = document.getElementById('preloader');
            preloader.style.display = 'none';
        }
    </script>
    <script src="../scripts/nav.js"></script>
    <script src="../scripts/loactor.js"></script>
</body>

</html>