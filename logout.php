<?php

session_start();

if (isset($_SESSION["UserId"])) {
    // Пользователь выходит
    unset($_SESSION["UserId"]);
}

// Возвращаем положительный статус
$status = [
    "Status" => 200,
    "Message" => "OK",
];
$jsonResult = json_encode($status);
echo $jsonResult;

?>