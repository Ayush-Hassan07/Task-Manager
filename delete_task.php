<?php
require 'auth_check.php';
require 'config.php';

$id = $_GET["id"];
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION["user_id"]]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$task) { echo "You Can Not Delete the Task."; exit(); }

if (isset($_GET['id'])) {
    $taskId = $_GET['id'];

    // Delete task from database
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$taskId]);

    // Redirect back to admin dashboard
    header("Location: admin_dashboard.php");
    exit();
} else {
    // If no ID is passed, go back to dashboard with error
    header("Location: admin_dashboard.php?error=invalid_task");
    exit();
}
