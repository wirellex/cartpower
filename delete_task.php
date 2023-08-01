<?php
if (isset($_GET['task_id'])) {
    $taskId = $_GET['task_id'];

    // Подключение к базе данных 

    include 'config.php';

    // Удаление задачи из базы данных по task_id
    $query = "DELETE FROM tasks WHERE id = $taskId";
    $result = mysqli_query($conn, $query);
}

// Перенаправляем обратно на стартовую страницу после удаления
header('Location: tasks_board.php');
exit;
?>
