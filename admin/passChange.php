<?php
if (!isset($_COOKIE['admin'])) {
    header("Location: ./login.php");
    exit();
}

$lastpass = $_POST['lpass'];
$newpass = $_POST['newpass'];

$sql = "SELECT * FROM `admins` WHERE pass = $lpass";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    $sql = "UPDATE `admins` SET pass=$newpass WHERE id = $id";
    $result = $mysqli->query($sql);
    if($result){
        setcookie("admin", "", time() - 3600, "/");
        setcookie("error", "Құпиясөз сәтті өзгерді", time() + 30, "/");
        header("../login.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>

<body>
    <form action="" method="post">
        <label for="lpass">Қазіргі құпиясөз:</label>
        <input type="text" name="lpass">

        <label for="newpass">Жаңа құпиясөз:</label>
        <input type="text" name="newpass">

        <button type="submit">Өзгерту</button>
    </form>
</body>

</html>