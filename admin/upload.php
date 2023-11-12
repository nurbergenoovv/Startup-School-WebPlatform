<?php
require_once"../includes/db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверяем, был ли отправлен файл
    if (isset($_FILES['cardPhoto'])) {
        $name = $_POST['name'];
        $jobTitle = $_POST['jobTitle'];

        $imageName = $_FILES['cardPhoto']['name'];
        $imageTmpName = $_FILES['cardPhoto']['tmp_name'];

        // Укажите путь для сохранения файла на сервере
        $uploadDirectory = 'uploads/';

        // Генерируем уникальное имя файла
        $uniqueName = uniqid('image_') . '_' . $imageName;

        $uploadPath = $uploadDirectory . $uniqueName;

        // Перемещаем загруженный файл в указанную директорию
        if (move_uploaded_file($imageTmpName, $uploadPath)) {

            // Подготовка SQL-запроса для вставки данных
            $sql = "INSERT INTO `cards` (name, job_title, image_url) VALUES (?, ?, ?)";

            // Создание подготовленного запроса
            if ($stmt = $mysqli->prepare($sql)) {
                // Привязываем параметры
                $stmt->bind_param("sss", $name, $jobTitle, $uploadPath);

                // Выполняем запрос
                if ($stmt->execute()) {
                    // Отправляем успешный ответ на клиентскую сторону
                    echo json_encode(array("success" => true));
                } else {
                    // Ошибка при выполнении запроса
                    echo json_encode(array("success" => false, "error" => "Ошибка при добавлении карточки."));
                }

                // Закрываем подготовленный запрос
                $stmt->close();
            } else {
                // Ошибка при создании подготовленного запроса
                echo json_encode(array("success" => false, "error" => "Ошибка при создании запроса."));
            }

            // Закрываем соединение с базой данных
            $mysqli->close();
        } else {
            // Ошибка при перемещении файла
            echo json_encode(array("success" => false, "error" => "Ошибка при загрузке фотографии."));
        }
    } else {
        // Поле 'cardPhoto' не было отправлено
        echo json_encode(array("success" => false, "error" => "Поле 'cardPhoto' не было отправлено."));
    }
} else {
    // Запрос не является POST-запросом
    echo json_encode(array("success" => false, "error" => "Запрос не является POST-запросом."));
}
?>
