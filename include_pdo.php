<?php
require_once "vendor/autoload.php";
require_once "utils.php";

$dbhost = "localhost"; // хост базы данных
$dbname = "coin_keeper"; // имя базы данных
$dbuser = "root"; // имя пользователя базы данных
$dbpass = ""; // пароль пользователя базы данных

// Подключение к базе данных
try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit("Ошибка в подключении к базе данных");
}