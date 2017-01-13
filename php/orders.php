<?php

session_start();

// Пользователи и из заказы (в реальности должны быть в БД)
$users = [
    "User1" => [
        [
            "Id" => 1,
            "Product" => "Some product 1",
            "Price" => 200,
        ],
        [
            "Id" => 2,
            "Product" => "Some product 2",
            "Price" => 400,
        ]
    ],
    "User2" => [], // Нет заказов
];

$user = "";

if (isset($_SESSION["UserId"])) {
    // Получаем пользователя
   $user = $_SESSION["UserId"];
} else {
    // Выводим ошибку, если пользователь не аутентифицирован
    $error = [
        "Status" => 401,
        "Message" => "Unauthorized",
    ];
    $jsonError = json_encode($error);
    echo $jsonError;
    exit();
}

// Возвращаем товары пользователя
$jsonResult = json_encode($users[$user]);
echo $jsonResult;

?>