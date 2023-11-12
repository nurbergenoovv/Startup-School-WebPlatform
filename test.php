<?php
session_start();
require_once('./includes/db.php');
if (!isset($_COOKIE['subject'])) {
    header("Location: ./student.php");
}

if ($mysqli->connect_error) {
    die('Ошибка подключения к базе данных: ' . $mysqli->connect_error);
}
$subject_type = $_GET['s'];


$questions_per_test = 10;
$lvl = '';

if (isset($_POST['start_test'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['difficulty'])) {
        $difficulty = $_POST['difficulty'];

        switch ($difficulty) {
            case 'easy':
                $questions_per_test = 10;
                $lvl = 'Жеңіл';
                break;
            case 'medium':
                $questions_per_test = 15;
                $lvl = 'Орташа';
                break;
            case 'hard':
                $questions_per_test = 20;
                $lvl = 'Қиын';
                break;
            default:
                $questions_per_test = 10;
        }
        setcookie("question_count", $questions_per_test, time() + 3600, "/");
        $query = "SELECT * FROM questions WHERE subject='$subject_type' ORDER BY RAND() LIMIT $questions_per_test";
        $result = $mysqli->query($query);

        $_SESSION['questions'] = [];

        while ($row = $result->fetch_assoc()) {
            $question = [
                'text' => $row['question_text'],
                'correct_answer' => $row['correct_answer']
            ];

            $incorrect_answers = explode(',', $row['incorrect_answers']);
            shuffle($incorrect_answers);

            $question['answers'] = $incorrect_answers;
            array_splice($question['answers'], rand(0, count($question['answers'])), 0, $question['correct_answer']);
            shuffle($question['answers']);

            $_SESSION['questions'][] = $question;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Тестовый сайт - Тест</title>
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

        .container {
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
            color: #000CFF;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-top: 65px;
        }

        form #input-btn {
            color: #FFF;

            text-align: center;
            font-family: Montserrat;
            font-size: 22px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            padding: 15px 50px;
            border-radius: 8px;
            background-color: rgba(0, 197, 8, 1);
            border: none;
            transition: .4s all ease-in-out;
        }

        select {
            width: 343px;
            height: 34px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            margin-bottom: 35px;
        }

        form #input-btn:hover {
            background-color: #048D09;
        }

        form label {
            color: #000CFF;
            text-align: center;
            font-family: Montserrat;
            font-size: 32px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
            font-variant: all-small-caps;
            margin-bottom: 30px;

        }

        #btn-btm {
            padding: 12px 61px;
            color: #000;
            text-align: center;
            font-family: Montserrat;
            font-size: 20px;
            font-style: normal;
            font-weight: 500;
            border-radius: 8px;
            background: #FFF;
            border: none;
            position: absolute;
            bottom: 50px;
            transition: .5s all ease-in-out;
        }

        #btn-btm:hover {
            background-color: grey;
            color: white;
        }

        .backgraound-modal {
            position: absolute;
            width: 100vw;
            height: 100vh;
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, .5);
            transition: .5s all ease-in-out;
        }

        .modal-window {
            width: 75vw;
            height: 70vh;
            position: relative;
            background-color: white;
            border-radius: 15px;
        }

        .modal-window button {
            width: 45px;
            height: 45px;
            border: none;
            border-radius: 50%;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            color: black;
            position: absolute;
            top: -50px;
            right: -50px;
        }

        .modal-window .content {
            display: flex;
            flex-direction: column;
            margin: 30px;
        }

        .test-screen {
            max-width: 85vw;
            width: 85vw;
            display: flex;
            align-items: start;
            color: #000CFF;
        }

        .test-screen span {
            color: #000CFF;
            text-align: center;
            font-family: Montserrat;
            font-size: 20px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }

        input[type="radio"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #000CFF;
            border-radius: 50%;
            outline: none;
            transition: border-color 0.3s ease-in-out;
            cursor: pointer;
        }

        input[type="radio"]:hover {
            border-color: #555DFF;
        }

        input[type="radio"]:checked {
            border-color: #000CFF;
            background-color: #000CFF;
        }

        .finish_test {
            margin-bottom: 50px;
            margin-left: 30px;
        }

        .question_cc {
            margin-top: -25px;
            color: #000CFF;
            text-align: center;
            font-family: Montserrat;
            font-size: 20px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }
    </style>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>

<body>
    <div class="container">
        <div class="backgraound-modal" id="modalWin">
            <div class="modal-window">
                <button id="close-modal" onclick="closeMoadalWin()"><span class="material-symbols-outlined">
                        close
                    </span></button>
                <div class="content">
                    <h2>
                        Моданльный окно
                    </h2>
                </div>
            </div>
        </div>
        <h1>
            <?php echo $_COOKIE['subject']; ?>
        </h1>

        <?php
        if (!$result) {
            echo "<form method='POST'>";
            echo '<label for="difficulty">Тест деңгейін таңдаңыз:</label>
        <select name="difficulty" id="difficulty">
            <option value="easy">Жеңіл (10 сұрақ)</option>
            <option value="medium">Орташа (15 сұрақ)</option>
            <option value="hard">Қиын (20 сұрақ)</option>
        </select>';
            echo "<input type='submit' name='start_test' value='Тестті бастау' id='input-btn'>";
            echo "</form>";
            echo '<button id="btn-btm" onclick="openMoadalWin()">Нұсқаулық</button>';
        } else {
            echo '<span class="question_cc">' . $lvl . ' - ' . $questions_per_test . ' сұрақ</span>';
            echo '<div class="test-screen">';
            echo "<form method='POST' action='results.php'>";
            echo "<ul>";

            foreach ($_SESSION['questions'] as $question_id => $question) {
                echo "<li>";

                echo "<span>" . ($question_id + 1) . " - cұрақ : " . $question['text'] . "</span><br>";

                foreach ($question['answers'] as $answer) {
                    echo "<input type='radio' name='user_answers[$question_id]' value='$answer' required>";
                    echo "<label> $answer</label><br>";
                }

                echo "</li><br>";
            }

            echo "</ul>";
            echo '<input type="submit" name="finish_test" value="Завершить тест" id="input-btn" class="finish_test">';
            echo "</form>";
            echo '</div>';
        }
        ?>
    </div>
    <script src="./script.js"></script>
</body>

</html>