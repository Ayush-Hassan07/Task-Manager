<?php
session_start();
require 'config.php';

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
    $email = $_POST["email"];

    if (empty($password) || empty($confirmPassword)) {
        $errors[] = "Both password fields are required.";
    } elseif ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    } else {
        // Hash the password before storing
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Update the password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$hashedPassword, $email]);

        // Clear the reset data in session
        unset($_SESSION['reset_user_id']);
        unset($_SESSION['reset_email']);

        $success = true;
        $_SESSION["success"] = "Your password has been updated successfully.";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Reset Password</title></head>
<body>
<h2>Reset Your Password</h2>

<?php if (!empty($errors)) {
    echo "<div class='alert alert-danger'>";
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
    echo "</div>";
} ?>

<?php if ($success): ?>
    <div class="alert alert-success">
        <p>Your password has been updated. Please <a href="login.php">log in</a> with your new password.</p>
    </div>
<?php endif; ?>

</body>
</html>