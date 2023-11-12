<?
if (!isset($_COOKIE['admin'])) {
    header("Location: ./login.php");
    exit();
}
require_once "../includes/functions.php";

$result = getCards();
if(isset($_POST['delCard'])){
    $id = $_POST['id'];
    DeleteCard($id);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Карточка Қосу</title>
    <style>
        .card_img {
            max-width: 200px;
        }

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

        .btn-style:hover {
            background-color: grey;
            color: white;
        }

        td a {
            text-decoration: none;
            padding: 5px 20px;
            background-color: #333;
            color: white;
            transition: .5s all ease-in-out;
        }

        td a:hover {
            background-color: rgba(255, 255, 255, 0.5);
            color: black;
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
        setcookie("error", "", time() - 3600, "/");
    }
    ?>
    <h1>Админ-панель</h1>
    <a href="./index.php" class="btn-style">Бас мәзір</a>
    <a href="./add_card.php" class="btn-style">Карточка қосу</a>
    <table>
        <tr>
            <th>#</th>
            <th>Есімі</th>
            <th>Описания</th>
            <th>Суреті</th>
            <th>іс әрекет</th>
        </tr>

        <?php
        $count = 1;

        while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <?php echo $count; ?>
                </td>
                <td>
                    <?php echo $row['namecard']; ?>
                </td>
                <td>
                    <?php echo $row['job_title']; ?>
                </td>
                <td>
                    <img src="<?php echo $row['image_url']; ?>" alt="image_card_<?php echo $row['id']; ?>" class="card_img">
                </td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delCard">Жою</button>
                    </form>
                </td>
            </tr>
            <?php
            $count++;
        endwhile;
        ?>
    </table>
</body>

</html>