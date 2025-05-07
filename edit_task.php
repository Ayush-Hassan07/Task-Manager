<?php
require 'auth_check.php';
require 'config.php';

$id = $_GET["id"];
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION["user_id"]]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$task) { echo "You Can Not Edit the Task."; exit(); }

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $due_date = $_POST["due_date"];
    $due_time = $_POST["due_time"];  // Get the due time from the form
    $status = $_POST["status"];
    
    // Update the task with the new time as well
    $stmt = $conn->prepare("UPDATE tasks SET title=?, description=?, due_date=?, due_time=?, status=? WHERE id=? AND user_id=?");
    $stmt->execute([$title, $description, $due_date, $due_time, $status, $id, $_SESSION["user_id"]]);
    
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
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

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            max-width: 600px;
        }

        h2 {
            text-align: center;
            color: #4e73df;
            font-size: 2.2rem;
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 20px;
            border: 1px solid #ccc;
            padding: 12px;
            margin-bottom: 15px;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 5px rgba(78, 115, 223, 0.5);
        }

        .btn-primary {
            background-color: #4e73df;
            border: none;
            padding: 10px 25px;
            font-size: 1.1rem;
            border-radius: 30px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            transform: scale(1.05);
        }

        .alert {
            text-align: center;
            font-size: 1.1rem;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Task</h2>

    <form method="POST">
        <div class="mb-3">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($task['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required><?= htmlspecialchars($task['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="<?= htmlspecialchars($task['due_date']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="due_time">Due Time</label>
            <input type="time" name="due_time" id="due_time" class="form-control" value="<?= htmlspecialchars($task['due_time']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
            </select>
        </div>
        <button class="btn btn-primary">Update Task</button>
    </form>
    <a href="admin_dashboard.php" class="btn-back w-100" style="text-decoration:none;">Back</a>
    
    <!-- Reminder Notification Section -->
    <?php
    $current_time = date('Y-m-d H:i:s');
    $due_datetime = $task['due_date'] . ' ' . $task['due_time'];

    if (strtotime($due_datetime) > strtotime($current_time)) {
        echo "<div class='alert alert-info'>Reminder: Your task is due soon at " . date('h:i A', strtotime($due_datetime)) . ".</div>";
    } else {
        echo "<div class='alert alert-warning'>Your task is past due.</div>";
    }
    ?>
</div>

</body>
</html>
