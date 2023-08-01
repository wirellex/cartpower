<?php
// Подключение к базе данных 

$dbHost = 'localhost';
    $dbName = 'u302396_test';
    $dbUser = 'u302396_test';
    $dbPassword = 'Password_2023';  
    $conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $taskText = isset($_POST['task_text']) ? $_POST['task_text'] : '';

     $query = "INSERT INTO tasks (username, email, task_text) VALUES ('$username', '$email', '$taskText')";
     $result = mysqli_query($conn, $query);

    // Перенаправляем обратно на стартовую страницу после добавления
    header('Location: tasks_board.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Добавить задачу</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Добавить задачу</h1>
    <form action="add_task.php" method="post">
        <label>Имя пользователя:</label>
        <input type="text" name="username" required><br>
        <label>E-mail:</label>
        <input type="email" name="email" required><br>
        <label>Текст задачи:</label><br>
        <textarea name="task_text" rows="5" cols="40" required></textarea><br>
        <input type="submit" value="Добавить">
    </form>
</body>
</html>
