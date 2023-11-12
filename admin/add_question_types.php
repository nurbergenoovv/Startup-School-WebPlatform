<?php
if (!isset($_COOKIE['admin'])) {
    header("Location: ./login.php");
    exit();
}
require_once('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = strtolower($_POST['name']);

    $query = "INSERT INTO questions_types (name) VALUES ('$name')";
    $result = $mysqli->query($query);
    if($result){
        setcookie("error", "Сұрақ категория сәтті қосылды", time() +30, "/");
        header("Location: ./question_types.php");
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
        .input-type input{
            width: 50vw;
            height: 4vh;
        }
    </style>
    <title>Жаңа сұрақ катергориясын қосу</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <div class="container">
        <h1>Жаңа сұрақ катергориясын қосу</h1>
        <form method="POST">
            <div class="input-type">
                <label for="name">Сұрақ категориясы:</label>
                <input type="text" id="name" name="name" required><br>
            </div>
            <button type="submit">Сохранить</button>
        </form>
    </div>
</body>

</html>