<?php
    @session_start();

    // Проверяем, была ли отправлена форма
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = isset($_POST['login']) ? $_POST['login'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        // Проверяем правильность логина и пароля
        if ($login === 'admin' && $password === '123') {
            // Авторизация успешна, сохраняем флаг в сессии
            $_SESSION['admin_logged_in'] = true;
            header('Location: tasks_board.php');
            exit;
        } else {
            $error = '<div class="error-msg">Неправильный логин или пароль</div>';
        }
    }
    ?><!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
    <link rel="stylesheet" type="text/css" href="login-styles.css">
</head>
<body>
    <h1>Авторизация</h1>
    <?php echo $error; ?>
    <!-- Форма для входа -->
    <form action="index.php" method="post">
        <label>Логин:</label>
        <input type="text" name="login" required><br>
        <label>Пароль:</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Войти" class="login-btn">
    </form>
</body>
</html>