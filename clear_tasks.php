<?php
// Подключение к базе данных 

$dbHost = 'localhost';
    $dbName = 'u302396_test';
    $dbUser = 'u302396_test';
    $dbPassword = 'Password_2023';  
    $conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

// Удаление всех задач из базы данных
    $query = "DELETE FROM tasks";
    $result = mysqli_query($conn, $query);

// Перенаправляем обратно на стартовую страницу после удаления
header('Location: tasks_board.php');
exit;
?>
