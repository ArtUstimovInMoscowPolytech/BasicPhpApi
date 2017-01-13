<?php

session_start();

$users = [
    "User1" => "Password1",
    "User2" => "Password2",
];

// Получаем содержимое тела запроса
$requestBody = file_get_contents('php://input');

// Второй подход. Передача json как значения поля формы
if (isset($_POST["data"])) {
    $requestBody = $_POST["data"];
}

// Выведет полученную json строку
//echo $requestBody;

// Декодируем json строку в ассоциативный массив http://php.net/manual/ru/function.json-decode.php
$request = json_decode($requestBody, true);

if ($request == null || !array_key_exists("UserName", $request) || !array_key_exists("Password", $request)) {
    // Если попали сюда, значит получили запрос, не удовлетворяющий API. Выводим ошибку
    $error = [
        "Status" => 400,
        "Message" => "Bad Request",
    ];

    // Кодируем ошибку в json и печатаем http://php.net/manual/ru/function.json-encode.php
    $jsonError = json_encode($error);
    echo $jsonError;
    exit();
}

// Если дошли до сюда, значит запрос корректен

// Проверяем, зарегистрирован ли пользователь с данным именем (для упрощения рассматривается случай без БД)
if (!array_key_exists($request["UserName"], $users)) {
    // Если попали сюда, то пользователя не существует. Выведем ошибку
    $error = [
        "Status" => 101,
        "Message" => "User Not Found",
    ];
    $jsonError = json_encode($error);
    echo $jsonError;
    exit();
}

// Поверям, что правильно введён пароль пользователя. По хорошему надо использовать хеширование паролей
if ($request["Password"] != $users[$request["UserName"]]) {
    // Пароли не совпадают. Выводим ошибку
    $error = [
        "Status" => 102,
        "Message" => "Wrong Password",
    ];
    $jsonError = json_encode($error);
    echo $jsonError;
    exit();
}

// Если дошли до сюда, то пользователя можно аутентифицировать
// В данном случае как id используется имя пользователя
$_SESSION["UserId"] = $request["UserName"];

// Возвращаем положительный статус
$status = [
    "Status" => 200,
    "Message" => "OK",
];
$jsonResult = json_encode($status);
echo $jsonResult;

?>