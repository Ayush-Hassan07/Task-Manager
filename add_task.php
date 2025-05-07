<?php
require 'auth_check.php';
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $due_date = $_POST["due_date"];
    $due_time = $_POST["due_time"];
    $status = 'pending'; // default status

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date, due_time, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $title, $description, $due_date, $due_time, $status]);

    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, rgb(16, 24, 26), rgb(113, 121, 167), rgb(164, 117, 135));
            background-size: 400% 400%;
            animation: gradientBackground 6s ease infinite;
            font-family: 'Arial', sans-serif;
        }

        @keyframes gradientBackground {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            color: #333;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #5c6bc0;
            border-radius: 30px;
            font-weight: 600;
            padding: 12px 25px;
            font-size: 1.1rem;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #3f51b5;
            transform: scale(1.05);
        }

        .form-control {
            border-radius: 25px;
            padding: 12px;
            font-size: 1.1rem;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #5c6bc0;
            box-shadow: 0 0 5px rgba(92, 107, 192, 0.6);
        }

        label {
            font-weight: bold;
            color: #333;
        }

        .btn-back {
            background-color: #f1f1f1;
            border-radius: 30px;
            padding: 10px 20px;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #dcdcdc;
            transform: scale(1.05);
        }

        .header-color {
            color: rgb(180, 191, 210);
        }
    </style>
</head>
<body class="container d-flex justify-content-center align-items-center" style="height: 100vh;">

    <div class="form-container col-md-6">
        <h2 class="mb-4 header-color">Add New Task</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Due Date</label>
                <input type="date" name="due_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Due Time</label>
                <input type="time" name="due_time" class="form-control" required>
            </div>
            <input type="hidden" name="status" value="pending">
            <button class="btn btn-primary mb-3 w-100">Add Task</button>
        </form>
        <a href="dashboard.php" class="btn-back w-100">Back</a>
    </div>

</body>
</html>
