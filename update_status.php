<?php
require 'auth_check.php';
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Basic security: check allowed values
    if (!in_array($status, ['pending', 'in_progress', 'completed'])) {
        echo "Invalid status";
        exit;
    }

    $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    echo "Status updated";
}
?>
