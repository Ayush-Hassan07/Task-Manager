<?php
require 'auth_check.php';
require 'config.php';
require 'header.php';

// Fetch tasks based on their statuses
$stmtPending = $conn->prepare("SELECT * FROM tasks WHERE status = 'pending' ORDER BY due_date");
$stmtPending->execute();
$pendingTasks = $stmtPending->fetchAll(PDO::FETCH_ASSOC);

$stmtInProgress = $conn->prepare("SELECT * FROM tasks WHERE status = 'in_progress' ORDER BY due_date");
$stmtInProgress->execute();
$inProgressTasks = $stmtInProgress->fetchAll(PDO::FETCH_ASSOC);

$stmtCompleted = $conn->prepare("SELECT * FROM tasks WHERE status = 'completed' ORDER BY due_date");
$stmtCompleted->execute();
$completedTasks = $stmtCompleted->fetchAll(PDO::FETCH_ASSOC);

// Fetch all users (admin purpose)
$stmtUsers = $conn->prepare("SELECT * FROM users WHERE id > 1");
$stmtUsers->execute();
$users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Team Leader Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
        body{
            background: linear-gradient(135deg, rgb(16, 24, 26), rgb(113, 121, 167), rgb(164, 117, 135));
            background-size: 400% 400%;
            animation: gradientBackground 6s ease infinite;
        }
        @keyframes gradientBackground {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .btn-success {
            background-color: #28a745;
            border-radius: 30px;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
        }
        .btn-success:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table th, table td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        table tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }
        .status-btn {
            border-radius: 20px;
            font-weight: 500;
            padding: 6px 12px;
            transition: all 0.3s ease-in-out;
        }
        .status-btn:hover {
            transform: scale(1.05);
        }
        .status-btn.pending {
            background-color: #e74a3b;
            color: white;
        }
        .status-btn.in_progress {
            background-color: #f39c12;
            color: white;
        }
        .status-btn.completed {
            background-color: #27ae60;
            color: white;
        }
        .btn-warning, .btn-danger {
            border-radius: 20px;
            padding: 6px 12px;
            font-weight: 500;
            transition: all 0.3s ease-in-out;
        }
        .btn-warning:hover {
            background-color: #f39c12;
            transform: scale(1.05);
        }
        .btn-danger:hover {
            background-color: #e74a3b;
            transform: scale(1.05);
        }
        .header-color {
            color: rgb(180, 191, 210);
        }
    </style>
</head>
<body class="container">

<a href="add_task.php" class="btn btn-success mb-3" style="background-color: rgb(123, 87, 162);">Add New Task</a>

<h2 class="mb-3 header-color">Pending Tasks</h2>
<table class="table table-bordered mb-4" id="pending-tasks">
    <thead>
        <tr><th>Title</th><th>Description</th><th>Due Date</th><th>Due Time</th><th>Remaining Time</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach ($pendingTasks as $task): ?>
        <?php
            $status = $task['status'];
            $statusClass = '';
            if ($status === 'pending') $statusClass = 'btn-danger';
            elseif ($status === 'in_progress') $statusClass = 'btn-warning';
            elseif ($status === 'completed') $statusClass = 'btn-success';
        ?>
        <tr class="task-row" data-status="<?= $status ?>" data-id="<?= $task['id'] ?>">
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td><?= htmlspecialchars($task['description']) ?></td>
            <td><?= $task['due_date'] ?></td>
            <td><?= $task['due_time'] ?></td>
            <td class="remaining-time" data-duedate="<?= $task['due_date'] ?>" data-duetime="<?= $task['due_time'] ?>"></td>
            <td>
                <button class="btn btn-sm <?= $statusClass ?> status-btn" data-id="<?= $task['id'] ?>" data-status="<?= $status ?>">
                    <?= ucfirst(str_replace('_', ' ', $status)) ?>
                </button>
            </td>
            <td>
                <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this task?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h2 class="mb-3 header-color">In Progress Tasks</h2>
<table class="table table-bordered mb-4" id="in-progress-tasks">
    <thead>
        <tr><th>Title</th><th>Description</th><th>Due Date</th><th>Due Time</th><th>Remaining Time</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach ($inProgressTasks as $task): ?>
        <?php
            $status = $task['status'];
            $statusClass = '';
            if ($status === 'pending') $statusClass = 'btn-danger';
            elseif ($status === 'in_progress') $statusClass = 'btn-warning';
            elseif ($status === 'completed') $statusClass = 'btn-success';
        ?>
        <tr class="task-row" data-status="<?= $status ?>" data-id="<?= $task['id'] ?>">
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td><?= htmlspecialchars($task['description']) ?></td>
            <td><?= $task['due_date'] ?></td>
            <td><?= $task['due_time'] ?></td>
            <td class="remaining-time" data-duedate="<?= $task['due_date'] ?>" data-duetime="<?= $task['due_time'] ?>"></td>
            <td>
                <button class="btn btn-sm <?= $statusClass ?> status-btn" data-id="<?= $task['id'] ?>" data-status="<?= $status ?>">
                    <?= ucfirst(str_replace('_', ' ', $status)) ?>
                </button>
            </td>
            <td>
                <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this task?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h2 class="mb-3 header-color">Completed Tasks</h2>
<table class="table table-bordered" id="completed-tasks">
    <thead>
        <tr><th>Title</th><th>Description</th><th>Due Date</th><th>Due Time</th><th>Remaining Time</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach ($completedTasks as $task): ?>
        <?php
            $status = $task['status'];
            $statusClass = '';
            if ($status === 'pending') $statusClass = 'btn-danger';
            elseif ($status === 'in_progress') $statusClass = 'btn-warning';
            elseif ($status === 'completed') $statusClass = 'btn-success';
        ?>
        <tr class="task-row" data-status="<?= $status ?>" data-id="<?= $task['id'] ?>">
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td><?= htmlspecialchars($task['description']) ?></td>
            <td><?= $task['due_date'] ?></td>
            <td><?= $task['due_time'] ?></td>
            <td class="remaining-time" data-duedate="<?= $task['due_date'] ?>" data-duetime="<?= $task['due_time'] ?>"></td>
            <td>
                <button class="btn btn-sm <?= $statusClass ?> status-btn" data-id="<?= $task['id'] ?>" data-status="<?= $status ?>">
                    <?= ucfirst(str_replace('_', ' ', $status)) ?>
                </button>
            </td>
            <td>
                <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this task?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h2 class="mb-3 header-color">Team Members</h2>
<table class="table table-bordered">
    <thead>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td>
                <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script>
document.querySelectorAll('.status-btn').forEach(button => {
    button.addEventListener('click', () => {
        const taskId = button.dataset.id;
        const currentStatus = button.dataset.status;

        let newStatus = '';
        if (currentStatus === 'pending') newStatus = 'in_progress';
        else if (currentStatus === 'in_progress') newStatus = 'completed';
        else if (currentStatus === 'completed') newStatus = 'pending';

        fetch('update_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${taskId}&status=${newStatus}`
        })
        .then(response => response.text())
        .then(data => {
            button.textContent = newStatus.replace('_', ' ').charAt(0).toUpperCase() + newStatus.slice(1).replace('_', ' ');
            button.dataset.status = newStatus;
            button.classList.remove('btn-danger', 'btn-warning', 'btn-success');

            if (newStatus === 'pending') button.classList.add('btn-danger');
            if (newStatus === 'in_progress') button.classList.add('btn-warning');
            if (newStatus === 'completed') button.classList.add('btn-success');

            const taskRow = button.closest('tr');
            const oldTableId = currentStatus.replace('_', '-') + '-tasks';
            const newTableId = newStatus.replace('_', '-') + '-tasks';
            const oldTable = document.querySelector(`#${oldTableId} tbody`);
            const newTable = document.querySelector(`#${newTableId} tbody`);

            oldTable.removeChild(taskRow);
            newTable.appendChild(taskRow);
            taskRow.dataset.status = newStatus;
        });
    });
});
</script>

<script>
function updateRemainingTimes() {
    const now = new Date();
    document.querySelectorAll('.remaining-time').forEach(cell => {
        const dueDate = cell.dataset.duedate;
        const dueTime = cell.dataset.duetime;
        const dueDateTime = new Date(`${dueDate}T${dueTime}`);
        const diff = dueDateTime - now;
        if (diff <= 0) {
            cell.innerText = "Overdue";
            cell.style.color = 'red';
        } else {
            const hours = Math.floor(diff / 3600000);
            const minutes = Math.floor((diff % 3600000) / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            cell.innerText = `${hours}h ${minutes}m ${seconds}s`;
        }
    });
}
setInterval(updateRemainingTimes, 1000);
updateRemainingTimes();
</script>

</body>
</html>
