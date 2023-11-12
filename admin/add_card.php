<?
if (!isset($_COOKIE['admin'])) {
    header("Location: ./login.php");
    exit();
}
require_once "../includes/db.php";
// Включить отображение всех ошибок и уведомлений
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Cardname = $_POST['name'];
    $jobTitle = $_POST['jobTitle'];
    $move = 'uploads/' . $_FILES['file']['name'];

    if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name'])) {
        // Если файл успешно загружен, выполните SQL-запрос
        $sql = "INSERT INTO cards (namecard, job_title, image_url) VALUES ('$Cardname', '$jobTitle', '$move')";
        $result = $mysqli->query($sql);

        if ($result) {
            setcookie("success", "Карточка успешно добавлена!", time() + 30, "/");
            header("Location: ../admin/cards.php");
            exit;
        } else {
            setcookie("error", "Ошибка при добавлении карточки", time() + 30, "/");
            header("Location: ../admin/cards.php");
            exit;
        }
    } else {
        // Если произошла ошибка при перемещении файла
        $imgError = $_FILES['file']['error'];
        echo "Ошибка при перемещении файла: $imgError";
    }
}
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/error.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админская панель</title>
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
</head>

<body>
    <center>
        <h1>Добавление карточки</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="input-type">
                <label for="name">Есімі:</label>
                <input type="text" name="name" required>
            </div>

            <div class="input-type">
                <label for="jobTitle">Толығырақ:</label>
                <input type="text" name="jobTitle">
            </div>

            <input type="file" name='file' accept="image/*" required>

            <button type="submit" name="add_card">Добавить карточку</button>
        </form>
    </center>
</body>

</html>