<?php

session_start();

// Пользователи (в реальности должны быть в БД)
$users = [
    "User1" => "Password1",
    "User2" => "Password2",
];

// Убеждаемся, что пользователь аутентифицирован
if (isset($_SESSION["UserId"])) {
    // Показываем, что пользователь аутентифицирован
    $status = [
        "Status" => 200,
        "Message" => "Hello, ".$_SESSION["UserId"],
    ];
    $jsonResult = json_encode($status);
    echo $jsonResult;
} else {
    // Выводим ошибку
    $error = [
        "Status" => 401,
        "Message" => "Unauthorized",
    ];
    $jsonError = json_encode($error);
    echo $jsonError;
}

?>