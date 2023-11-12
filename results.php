<?php
session_start();
require_once "./includes/db.php";
require_once "./includes/functions.php";

$questions = $_SESSION['questions'];
$user_answers = $_POST['user_answers'];
$correct_count = 0;

foreach ($questions as $question_id => $question) {
    $correct_answer = $question['correct_answer'];
    if ($user_answers[$question_id] == $correct_answer) {
        $correct_count++;
        setcookie("correct_count", $correct_count, time() + 3600, "/");
        $userid = $_COOKIE['id'];
        $sql = "SELECT * FROM students WHERE id=$userid";
        $result = $mysqli->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            $lscore = $row['score'];
            $newscore = ($_COOKIE['score'] + $correct_count);
            $sql = "UPDATE students SET score = $newscore WHERE id=$userid";
            $result = $mysqli->query($sql);
            if($result){
                setcookie("score", $newscore, time()+3600, "/");
            }

        }
    }
}
if (!isset($_SESSION['questions']) || !isset($_POST['finish_test'])) {
    gohome($_COOKIE['correct_count']);
}
if (isset($_POST['home'])) {
    gohome($_COOKIE['correct_count']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Тестовый сайт - Результаты</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./icon.jpeg" />
    <style>
        html {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat';
        }

        body {
            background-image: url('./images/background/login-bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .box {
            width: 100vw;
            height: 100vh;
            display: flex;
            position: relative;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            margin-top: 11vh;
            font-size: 64px;
            font-style: normal;
            font-weight: 700;
            color: white;
        }

        p {
            color: #FFF;
            font-family: Montserrat;
            font-size: 32px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            font-variant: all-small-caps;
        }

        span {
            color: #FFF;
            text-align: center;
            font-family: Montserrat;
            font-size: 32px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
            font-variant: all-small-caps;
        }

        .pre-timer {
            margin-top: 20px;
        }

        #timer {
            color: #FFF;
            text-align: center;
            font-family: Montserrat;
            font-size: 32px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            font-variant: all-small-caps;
        }

        form button {
            color: #FFF;
            text-align: center;
            font-family: Montserrat;
            font-size: 32px;
            font-style: normal;
            margin-top: 50px;
            font-weight: 600;
            line-height: normal;
            font-variant: all-small-caps;
            padding: 17px 48px;
            border-radius: 8px;
            background-color: red;
            border: none;
            transition: .4s all ease-in-out;
        }

        form button:hover {
            background-color: #B72525;
        }
    </style>

</head>

<body>
    <div class="box">
        <h1>
            <?php echo $_COOKIE['subject']; ?>
        </h1>
        <p>Сіздің тест қорытындыңыз :
            <?php echo $_COOKIE["question_count"]; ?> /
            <?php echo $correct_count; ?>
        </p>
        <span>
        </span>
        <form action="" method="post">
            <button type="submit" name="home">
                Басты бетке оралу
            </button>
        </form>
    </div>
</body>

</html>