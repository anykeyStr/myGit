<?php


if (isset($_POST['new_psw']) && !empty($_POST['new_psw'])) {
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
//    $id = $_COOKIE['user_id'];
    $url .= "/user";

// Данные для отправки в теле запроса (если необходимо)
    $data = [
        'id' => $_COOKIE['user_id'],
        'new_psw' => $_POST['new_psw'],
    ];

// Настройки cURL
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'PUT', // Метод запроса
        CURLOPT_POSTFIELDS => http_build_query($data) // Данные для отправки
    ];

// Инициализация cURL-сессии
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
} else {
    ?>

<form action=<?=$_SERVER['PHP_SELF']?> method="post">
    <label for="new_psw"> Введите новый пароль
        <input type="text" name="new_psw" class="form-control">
    </label>
    <button class="btn btn-link" type="submit" class="w-50 btn btn-lg btn-primary">Изменить пароль</button>
</form>


<a href="../users/<?=$_COOKIE['user_id']?>">Вернуться</a>
<?php
}