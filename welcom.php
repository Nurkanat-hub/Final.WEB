<?php
//welcome.php
session_start(); // Начало сессии

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Если не авторизован, перенаправляем на страницу входа
    exit();
}

echo "Добро пожаловать, " . $_SESSION['user_email'] . "!";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Добро пожаловать в ваш личный кабинет!</h1>
        <p>Вы успешно вошли в систему.</p>
        <a href="logout.php" class="btn btn-danger">Выйти</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
