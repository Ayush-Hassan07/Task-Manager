<?php
if (!isset($_SESSION)) session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

        /* Fancy gradient background */
        .navbar {
            background: linear-gradient(to right,rgb(123, 87, 162),rgb(75, 98, 139));
            transition: background 0.5s ease-in-out;
        }

        .navbar:hover {
            background: linear-gradient(to right,rgb(95, 231, 255),rgb(99, 118, 227));
        }

        /* Add some padding and round the edges for buttons */
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .navbar-text {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .btn-outline-light {
            border-radius: 30px;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
        }

        /* Hover effect for logout button */
        .btn-outline-light:hover {
            background-color: #fff;
            color:rgb(16, 50, 110);
            border-color: #2575fc;
            transform: scale(1.1);
        }

        /* Add some shadow to the navbar */
        .navbar {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Navbar collapsible menu */
        .navbar-toggler-icon {
            background-color: #fff;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Task Manager</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="d-flex ms-auto">
                <span class="navbar-text text-white me-3">Hi, <?= $_SESSION['user_name'] ?? 'Guest'; ?></span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>