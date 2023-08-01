        <!DOCTYPE html>
<html>
<head>
    <title>Задачник</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
    <h1>Список задач</h1>
    <!-- Форма для выбора сортировки -->
    <form action="tasks_board.php" method="get" class="sort-form">
        <label>Сортировать по:</label>
        <select name="sort_by">
            <option value="username">Имя пользователя</option>
            <option value="email">E-mail</option>
            <option value="status">Статус</option>
        </select>
        <input type="submit" value="Сортировать">
    </form>
    <br>

    <!-- Кнопка выхода из аккаунта -->
    <a href="logout.php" class="logout-btn">Выйти из аккаунта</a>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // Подключение к базе данных
    
    include 'config.php';

    // Пагинация
    $itemsPerPage = 3;
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $startFrom = ($currentPage - 1) * $itemsPerPage;

    // Сортировка
    $sortField = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'username';
    $allowedFields = ['username', 'email', 'status'];
    if (!in_array($sortField, $allowedFields)) {
        $sortField = 'username'; // По умолчанию сортируем по имени пользователя
    }

    // Получение списка задач из базы данных с учетом сортировки и пагинации
    $query = "SELECT * FROM tasks ORDER BY $sortField LIMIT $startFrom, $itemsPerPage";
    $result = mysqli_query($conn, $query);
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Вывод списка задач
    if ($tasks) {
        echo '<ul>';
        foreach ($tasks as $task) {
            echo '<li>';
            echo 'Имя пользователя: ' . htmlspecialchars($task['username']) . '<br>';
            echo 'E-mail: ' . htmlspecialchars($task['email']) . '<br>';
            echo 'Текст задачи: ' . htmlspecialchars($task['task_text']) . '<br>';
            if ($task['status'] == 1) {
                echo 'Статус: Выполнено<br>';
                if ($task['edited_by_admin'] == 1) {
                    echo 'Отредактировано администратором<br>';
                }
            } else {
                echo 'Статус: В процессе<br>';
            }
            echo '<a class="edit-btn" href="edit_task.php?task_id=' . $task['id'] . '">Редактировать</a>'; 
            echo '<a class="delete-task-btn" href="delete_task.php?task_id=' . $task['id'] . '">Удалить</a>';
                echo '</li>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<div class="container">Нет задач</div>';
    }

    // Пагинация
    $stmt = $conn->query("SELECT COUNT(*) FROM tasks");
    $totalItems = $stmt->fetch_row()[0];
    $totalPages = ceil($totalItems / $itemsPerPage);

    echo '<br>Страницы: ';
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i === $currentPage) {
            echo "$i ";
        } else {
            echo "<a href=\"tasks_board.php?page=$i&sort_by=$sortField\">$i</a> ";
        }
    }
    ?>
        <a href="add_task.php" class="add-task-btn">Добавить задачу</a>
        <a href="clear_tasks.php" class="clear-tasks-btn">Очистить все задачи</a>
    </div>
</body>
</html>