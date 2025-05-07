<?php
require 'auth_check.php';
require 'config.php';

// Check if user ID is provided
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Delete the user from the database
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);

    // Redirect back to the admin dashboard after deletion
    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "No user selected for deletion.";
}
