<?php
if (!isset($_COOKIE['admin'])) {
    header("Location: ./login.php");
    exit();
}
require_once('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $class = $_POST['class'];


    $query = "UPDATE students SET firstname = '$fname', lastname = '$lname', class = '$class' WHERE id = $id";
    $result = $mysqli->query($query);
    if($result){
        setcookie("error", "Өзгертулер сәтті енгізілді", time()+30, "/");
        header("Location: ./students.php");
        exit();
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM students WHERE id = $id";
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
    <title>Оқушы мәліметін өзгерту</title>
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
    <h1>Оқушы мәліметін өзгерту</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="question_text">Есімі:</label>
        <input type="text" id="fname" name="fname" value="<?php echo $row['firstname']; ?>" required><br>

        <label for="correct_answer">Тегі:</label>
        <input type="text" id="lname" name="lname" value="<?php echo $row['lastname']; ?>" required><br>

        <label for="incorrect_answers">Сыныбы:</label>
        <input type="text" id="class" name="class" value="<?php echo $row['class']; ?>" required><br>

        <button type="submit">Сохранить</button>
    </form>
</body>
</html>
