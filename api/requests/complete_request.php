<?php
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id > 0) {
        $sql = "UPDATE requests SET status = 'done' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Статус обновлён.";
        } else {
            echo "Ошибка при обновлении статуса: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Некорректный ID.";
    }
} else {
    echo "Некорректный метод запроса.";
}

$conn->close();
