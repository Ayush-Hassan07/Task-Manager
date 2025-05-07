<?php
session_start();
require 'config.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $errors[] = "Email and password are required.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];

            // Check if the user is admin (id = 1)
            if ($user["id"] == 1) {
                // Pass only specific user information in the URL
                header("Location: admin_dashboard.php?user_id=" . $user["id"]);
            } else {
                // Pass only specific user information in the URL
                header("Location: dashboard.php?user_id=" . $user["id"]);
            }
            exit();
        } else {
            $errors[] = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        h3 {
            text-align: center;
            color: #333;
            font-family: 'Arial', sans-serif;
            font-weight: 600;
            margin-bottom: 30px;
            font-size: 36px;
            background: linear-gradient(45deg,rgb(50, 94, 207), #ff6b6b, #ffb74d);
            -webkit-background-clip: text;
            color: transparent;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2), 0 0 25px rgba(255, 105, 180, 0.5);
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        h3:hover {
                text-shadow: 2px 2px 10px rgba(43, 128, 208, 0.3), 0 0 25px rgba(54, 143, 172, 0.7);
                transform: scale(1.05);
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
        .btn-dark {
            background-color: #6c63ff;
            border-radius: 30px;
            padding: 10px 20px;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .btn-dark:hover {
            background-color: #5a54db;
            transform: scale(1.05);
        }

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

        /* Alert Styles */
        .alert-danger, .alert-success {
            margin-bottom: 20px;
            padding: 15px;
            font-weight: 500;
        }

        /* Image Styling */
        .img-fluid {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
    <div class="container mt-1">
            <!-- Form Container -->
            <div class="p-5">
                <!-- Welcome Message -->
                <h3>Welcome to Task Manager!</h3>
                <h2>Login</h2>

                <!-- Success and Error Messages -->
                <?php 
                    if (!empty($_SESSION["success"])) {
                        echo "<div class='alert alert-success'>".$_SESSION["success"]."</div>";
                        unset($_SESSION["success"]);
                    }
                    if (!empty($errors)) {
                        echo "<div class='alert alert-danger'>";
                        foreach ($errors as $e) echo "<p>$e</p>";
                        echo "</div>";
                    }
                ?>

                <!-- Login Form -->
                <form method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3 pb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <button class="btn btn-dark">Login</button>
                    <a href="register.php" class="btn btn-link">Create an Account</a>
                    <a href="forgot_password.php" class="btn btn-link">Forgot Password?</a>
                </form>
            <!-- </div> -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
