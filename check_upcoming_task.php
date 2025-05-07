<?php
require 'config.php';

header('Content-Type: application/json');

$now = new DateTime();
$thirtyMinutesLater = (new DateTime())->add(new DateInterval('PT30M'));

$stmt = $conn->prepare("SELECT * FROM tasks WHERE status != 'completed' AND 
                        CONCAT(due_date, ' ', due_time) BETWEEN :now AND :thirtyMinutesLater");
$stmt->execute([
    ':now' => $now->format('Y-m-d H:i:s'),
    ':thirtyMinutesLater' => $thirtyMinutesLater->format('Y-m-d H:i:s')
]);

$upcomingTasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($upcomingTasks);
?>