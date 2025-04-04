<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    $cleanPhone = preg_replace('/\D/', '', $phone);

    if (preg_match('/^7\d{10}$/', $cleanPhone)) {
        $stmt = $conn->prepare("INSERT INTO requests (phone) VALUES (?)");
        $stmt->bind_param("s", $cleanPhone);

        if ($stmt->execute()) {
            echo "Запрос успешно отправлен";
        } else {
            echo "Ошибка: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Некорректный номер телефона.";
    }
} else {
    echo "Неверный метод запроса.";
}

$conn->close();
