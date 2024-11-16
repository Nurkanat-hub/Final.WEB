<?php
//login.php
session_start(); // Начинаем сессию

include('db.php'); // Подключение к базе данных

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    // Запрос на выборку пользователя по email
    $sql = "SELECT * FROM SignIn WHERE Email_Address = $1";
    $result = pg_query_params($conn, $sql, array($email));

    if (pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);

        // Проверка пароля
        if (password_verify($password, $user['Password'])) {
            // Устанавливаем сессионные переменные
            $_SESSION['user_id'] = $user['id']; // Предполагаем, что id — это поле в таблице
            $_SESSION['user_email'] = $user['Email_Address'];

            // Перенаправляем на страницу профиля
            header("Location: Profile.html");
            exit();
        } else {
            echo "Неверный пароль!";
        }
    } else {
        echo "Пользователь не найден!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Вход</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="Email" class="form-label">Электронная почта</label>
                <input type="email" class="form-control" id="Email" name="Email" required>
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="Password" name="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
