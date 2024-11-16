<?php
//register.php
session_start(); // Начинаем сессию

include('db.php'); // Подключение к базе данных

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['FullName'];
    $age = $_POST['Age'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    // Проверка на существование пользователя
    $sql_check = "SELECT * FROM SignIn WHERE Email_Address = $1";
    $result = pg_query_params($conn, $sql_check, array($email));

    if (pg_num_rows($result) > 0) {
        echo "Этот email уже зарегистрирован.";
    } else {
        // Хешируем пароль
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Вставка данных в таблицу
        $sql_insert = "INSERT INTO SignIn (Full_Name, Age, Email_Address, Password) VALUES ($1, $2, $3, $4)";
        $insert_result = pg_query_params($conn, $sql_insert, array($full_name, $age, $email, $hashed_password));

        if ($insert_result) {
            // Устанавливаем сессионные переменные
            $_SESSION['user_email'] = $email;
            $_SESSION['user_id'] = pg_last_oid($insert_result); // Получаем ID нового пользователя из базы данных

            // Перенаправляем на страницу профиля
            header("Location: Profile.html");
            exit();
        } else {
            echo "Ошибка: " . pg_last_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Регистрация</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="FullName" class="form-label">Полное имя</label>
                <input type="text" class="form-control" id="FullName" name="FullName" required>
            </div>
            <div class="mb-3">
                <label for="Age" class="form-label">Возраст</label>
                <input type="number" class="form-control" id="Age" name="Age" required>
            </div>
            <div class="mb-3">
                <label for="Email" class="form-label">Электронная почта</label>
                <input type="email" class="form-control" id="Email" name="Email" required>
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="Password" name="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
