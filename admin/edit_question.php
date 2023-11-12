<?php
if (!isset($_COOKIE['admin'])) {
    header("Location: ./login.php");
    exit();
}
require_once('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $question_text = $_POST['question_text'];
    $correct_answer = $_POST['correct_answer'];
    $incorrect_answers = $_POST['incorrect_answers'];
    $subject = $_POST['type'];


    $query = "UPDATE questions SET question_text = '$question_text', correct_answer = '$correct_answer', incorrect_answers = '$incorrect_answers', subject = '$subject' WHERE id = $id";
    $mysqli->query($query);

    header("Location: ./questions.php");
    exit();
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM questions WHERE id = $id";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
    } else {
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Редактировать вопрос</title>
    <style>
        /* Стили для админ-панели */

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
form{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

form input{
    width: 65%;
    height: 35px;
    background-color: white;
    border: 2px black solid;
    font-size: 22px;
    outline: none;
    padding-inline: 5px;
    border-radius: 11px;
}
button {
    padding: 10px 20px;
    font-size: 22px;
    background-color: #333;
    color: #fff;
    border: none;
    cursor: pointer;
    border-radius: 11px;
}
label{
    font-size: 22px;
    font-weight: 500;
}
button:hover {
    background-color: #555;
}
    </style>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <h1>Редактировать вопрос</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="question_text">Текст вопроса:</label>
        <input type="text" id="question_text" name="question_text" value="<?php echo $row['question_text']; ?>" required><br>

        <label for="correct_answer">Правильный ответ:</label>
        <input type="text" id="correct_answer" name="correct_answer" value="<?php echo $row['correct_answer']; ?>" required><br>

        <label for="incorrect_answers">Неправильные ответы (через запятую):</label>
        <input type="text" id="incorrect_answers" name="incorrect_answers" value="<?php echo $row['incorrect_answers']; ?>" required><br>

        <label for="incorrect_answers">Пән:</label>
        <input type="text" id="type" name="type" value="<?php echo $row['subject']; ?>" required><br>

        <button type="submit">Сохранить</button>
    </form>
</body>
</html>
