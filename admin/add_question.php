<?php
if (!isset($_COOKIE['admin'])) {
    header("Location: ./login.php");
    exit();
}
require_once('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_text = $_POST['question_text'];
    $correct_answer = $_POST['correct_answer'];
    $incorrect_answers = $_POST['incorrect_answers'];
    $difficulty = $_POST['difficulty'];

    $sql = "SELECT * FROM `questions_types` WHERE id=$difficulty";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $type = $row['name'];
        echo $type;
    }
    $query = "INSERT INTO questions (question_text, correct_answer, incorrect_answers, subject) VALUES ('$question_text', '$correct_answer', '$incorrect_answers', '$type')";
    $result = $mysqli->query($query);
    if ($result) {
        setcookie("error", "Сұрақ сәтті қосылды", time() + 30, "/");
        header("Location: ./questions.php");
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        button {
            padding: 5px 10px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        @media screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }

            table {
                font-size: 14px;
            }

            th,
            td {
                padding: 5px;
            }
        }

        .container {
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        form {
            width: 85vw;
            height: 85vh;
            border-radius: 15px;
            background-color: grey;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            row-gap: 5px;
        }

        .input-type {
            display: flex;
            flex-direction: column;
        }

        .input-type input {
            width: 50vw;
            height: 4vh;
        }
    </style>
    <title>Добавить вопрос</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <div class="container">
        <h1>Жаңа сұрақ қосу</h1>
        <form method="POST">
            <div class="input-type">
                <label for="question_text">Сұрақ:</label>
                <input type="text" id="question_text" name="question_text" required><br>
            </div>
            <div class="input-type">
                <label for="correct_answer">Дұрыс жауап:</label>
                <input type="text" id="correct_answer" name="correct_answer" required><br>
            </div>
            <div class="input-type">
                <label for="incorrect_answers">Дұрыс емес жауаптар (үтір арқылы):</label>
                <input type="text" id="incorrect_answers" name="incorrect_answers" required><br>
            </div>
            <div class="input-type">
                <label for="type">Пән:</label>
                <select name="difficulty" id="difficulty">
                    <?php
                    $sql = "SELECT * FROM questions_types";
                    $result = $mysqli->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()): ?>
                            <option class="grid-item" value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                        <?php endwhile;
                    } else {
                        echo "<p>Сурак категориялары алы косылмады</p>";
                    } ?>
                </select>
            </div>
            <button type="submit">Сохранить</button>
        </form>
    </div>
</body>

</html>