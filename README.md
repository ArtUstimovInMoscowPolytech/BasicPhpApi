# Basic PHP API

Простейший пример Web API на PHP и взаимодействия с ним из C#

## Примеры

* аутентификация пользователя (auth.php)

* логаут пользователя (logout.php)

* получение данных, соответсвующих определённому пользователю (orders.php)

## Подход первый (предпочтительный)

В данном случае JSON извлекается из тела запроса

### Выполнение запроса из Postman

![first](https://raw.githubusercontent.com/Ustimov/BasicPhpApi/master/img/1.png)

### Выполнение запроса из C# #

```csharp
var json = new JObject { { "UserName", userName }, { "Password", password } };
var response = await _client.PostAsync($"{_baseUrl}/auth.php", new StringContent(json));
```

### Обработка запроса в PHP

```php
$requestBody = file_get_contents('php://input');
$request = json_decode($requestBody, true);
$userName = $request["UserName"];
$password = $request["Password"];
```

## Подход второй

JSON передаётся как значение поля формы

### Выполнение запроса из Postman

![first](https://raw.githubusercontent.com/Ustimov/BasicPhpApi/master/img/2.png)

### Выполнение запроса из C# #

```csharp
var json = new JObject { { "UserName", userName }, { "Password", password } };
var content = new FormUrlEncodedContent(new[] { new KeyValuePair<string, string>("data", json) });
var response = await _client.PostAsync($"{_baseUrl}/auth.php", content);
```

### Обработка запроса в PHP

```php
$requestBody = $_POST["data"];
$request = json_decode($requestBody, true);
$userName = $request["UserName"];
$password = $request["Password"];
```

# Примечание

Исходный код содержит полный пример и включает несколько PHP скриптов, а также консольный C# клиент
