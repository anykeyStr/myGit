<?php
if(isset($_GET['delete_id']) && !empty(isset($_GET['delete_id']))) {

    $delete_id = $_GET['delete_id'];
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
    $url .= "/admin/user/$delete_id";

    $data = [
        'id' => $delete_id,
    ];

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'DELETE', // Метод запроса
        CURLOPT_POSTFIELDS => http_build_query($data) // Данные для отправки
    ];

    $ch = curl_init();
    curl_setopt_array($ch, $options);

// Выполнение запроса
    $response = curl_exec($ch);

// Обработка ответа
    if ($response !== false) {
// Вывод ответа
        echo $response;
        echo "<br><a href='../users/{$_COOKIE['user_id']}'> Назад </a>";
    } else {
// Вывод ошибки
        echo curl_error($ch);
    }

// Завершение cURL-сессии
    curl_close($ch);

}







// Инициализация cURL-сессии


