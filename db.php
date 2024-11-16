<?php
//db.html
$servername = "server1"; // Сервер базы данных
$username = "postgres"; // Имя пользователя
$password = "1234"; // Пароль
$dbname = "KazDiscover"; // Имя базы данных

// Создание подключения
$conn = pg_connect("host=$servername dbname=$dbname user=$username password=$password");

// Проверка подключения
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>
