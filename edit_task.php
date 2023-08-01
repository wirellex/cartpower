<?php
// Проверяем, авторизован ли администратор
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Подключение к базе данных 

    include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = isset($_POST['task_id']) ? (int)$_POST['task_id'] : 0;
    $editedText = isset($_POST['edited_text']) ? $_POST['edited_text'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : 0;
    $editedByAdmin = isset($_POST['edited_by_admin']) ? 1 : 0;

    // Обновление текста задачи и статуса в базе данных
    $query = "UPDATE tasks SET task_text = '$editedText', status = $status, edited_by_admin = $editedByAdmin WHERE id = $taskId";
    $result = mysqli_query($conn, $query);

    // Перенаправляем обратно на стартовую страницу после редактирования
    header('Location: tasks_board.php');
    exit;
} else {
    $taskId = isset($_GET['task_id']) ? (int)$_GET['task_id'] : 0;

    // Получение информации о задаче из базы данных
    $query = "SELECT * FROM tasks WHERE id = $taskId";
    $result = mysqli_query($conn, $query);
    $task = mysqli_fetch_assoc($result);

    if (!$task) {
        echo 'Задача не найдена';
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Редактирование задачи</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Редактирование задачи</h1>
    <form action="edit_task.php" method="post">
        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
        <label>Имя пользователя:</label>
        <input type="text" value="<?php echo htmlspecialchars($task['username']); ?>" disabled><br>
        <label>E-mail:</label>
        <input type="text" value="<?php echo htmlspecialchars($task['email']); ?>" disabled><br>
        <label>Текст задачи:</label><br>
        <textarea name="edited_text" rows="5" cols="40"><?php echo htmlspecialchars($task['task_text']); ?></textarea><br>
        <label>Выполнено:</label>
        <input type="checkbox" name="status" value="1" <?php echo $task['status'] ? 'checked' : ''; ?>><br>
        <label>Отредактировано администратором:</label>
        <input type="checkbox" name="edited_by_admin" value="1" <?php echo $task['edited_by_admin'] ? 'checked' : ''; ?>><br>
        <input type="submit" value="Сохранить">
    </form>
</body>
</html>
