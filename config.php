<?php
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'user';
$db_pass = getenv('DB_PASS') ?: 'password';
$db_name = getenv('DB_NAME') ?: 'advertisement_db';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("Ошибка подключения к базе данных: " . $mysqli->connect_error . 
        ". Проверьте настройки подключения в docker-compose.yml");
}

$mysqli->set_charset("utf8");

function log_error($message) {
    error_log("Advertisement Form Error: " . $message);
}
?>