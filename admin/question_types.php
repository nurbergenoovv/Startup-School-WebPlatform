<?php
if (!isset($_COOKIE['admin'])) {
    header("Location: ./login.php");
    exit();
}
require_once ("../includes/db.php");

$query = "SELECT * FROM `questions_types`";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
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
            margin-bottom: 50px;
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

        /* Медиа-запрос для мобильных устройств */
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

        .btn-style {
            padding: 10px 25px;
            text-decoration: none;
            margin-top: 70px;
            margin-bottom: 50px;
            background-color: black;
            color: white;
            margin-left: 15px;
            transition: .5s all ease-in-out;
        }
        .btn-style:hover{
            background-color: grey;
            color: white;
        }
        td a{
            text-decoration: none;
            padding: 5px 20px;
            background-color: #333;
            color: white;
            transition: .5s all ease-in-out;
        }
        td a:hover{
            background-color: rgba(255, 255, 255, 0.5);
            color: black;
        }
    </style>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../styles/error.css">
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
    <h1>Админ-панель</h1>
    <a href="./index.php" class="btn-style">Бас мәзір</a>
    <a href="./add_question_types.php" class="btn-style">Сұрақ катергория қосу</a>
    <table>
        <tr>
            <th>№</th>
            <th>Катергория</th>
            <th>Іс әрекеттер</th>
        </tr>

        <?php
        $count = 1;

        while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <?php echo $count; ?>
                </td>
                <td>
                    <?php echo $row['name']; ?>
                </td>
                <td>
                    <a href="delete_question_type.php?id=<?php echo $row['id']; ?>">Кетіру</a>
                </td>
            </tr>
            <?php
            $count++;
        endwhile;
        ?>
    </table>
</body>

</html>