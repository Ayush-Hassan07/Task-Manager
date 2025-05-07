<?php
session_start();
require 'config.php';

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);

    if (empty($email)) {
        $errors[] = "Email is required.";
    } else {
        // Check if the email exists in the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Set user in session to carry data to the reset password form
            $_SESSION['reset_user_id'] = $user['id'];
            $_SESSION['reset_email'] = $user['email'];
            $success = true;
        } else {
            $errors[] = "No user found with that email address.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background Gradient */
        body {
            background: linear-gradient(135deg, rgb(95, 231, 255), rgb(99, 118, 227));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            color: #333;
            font-family: 'Arial', sans-serif;
            font-weight: 600;
            margin-bottom: 30px;
        }

        /* Form Inputs */
        .form-control {
            border-radius: 25px;
            padding: 12px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #6c63ff;
            box-shadow: 0 0 8px rgba(108, 99, 255, 0.6);
        }

        /* Buttons */
        .btn-primary {
            background-color: #6c63ff;
            border-radius: 30px;
            padding: 10px 20px;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #5a54db;
            transform: scale(1.05);
        }

        /* Alert Styles */
        .alert-danger {
            margin-bottom: 20px;
            padding: 15px;
            font-weight: 500;
        }

        /* Links */
        .btn-link {
            text-align: center;
            font-size: 14px;
            color: #6c63ff;
            text-decoration: none;
            font-weight: 500;
            display: block;
            margin-top: 10px;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .container {
                padding: 20px;
            }
            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Forgot Password</h2>

        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error) echo "<p>$error</p>"; ?>
            </div>
        <?php endif; ?>

        <!-- Form for Email or New Password -->
        <?php if (!$success): ?>
            <!-- Step 1: Email input form -->
            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        <?php else: ?>
            <!-- Step 2: New Password form -->
            <form method="POST" action="reset_password.php">
                <input type="hidden" name="email" value="<?= $_SESSION['reset_email']; ?>" />
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

