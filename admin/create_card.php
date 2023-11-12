<?
require_once "../includes/db.php";
// Включить отображение всех ошибок и уведомлений
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Cardname = $_POST['name'];
    $jobTitle = $_POST['jobTitle'];
    $cardPhoto = $_FILES['file'] ?? null;

    $imgFile = $_FILES['file'];
    $tmp_name = $imgFile["tmp_name"][$key];

    $uniqueName = uniqid('image_') . '_' . $imgFile['name'];
    $move = $uploadDirectory . $uniqueName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name'])) {
        // Если файл успешно загружен, выполните SQL-запрос
        $sql = "INSERT INTO `cards` (name, job_title, image_url) VALUES ($Cardname, $jobTitle, '$move')";
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
        $imgError = $_FILES['cardPhoto']['error'];
        echo "Ошибка при перемещении файла: $imgError";
    }
}

?>