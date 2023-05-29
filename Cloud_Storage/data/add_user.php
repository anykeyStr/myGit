<?php


if (isset($_POST['new_user']) && !empty($_POST['new_user']) && !empty($_POST['new_user_psw'])) {

    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . "/user";

    // проверка на корректность e-mail адреса
    $new_user = filter_var($_POST['new_user'], FILTER_VALIDATE_EMAIL);
    $new_user_psw = $_POST['new_user_psw'];

    // Данные для отправки в теле запроса
    $data = [
        'new_user' => $new_user,
        'new_user_psw' => $new_user_psw,
    ];

// Настройки cURL
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST', // Метод запроса
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
    <h2>Добавление нового пользователя</h2>
    <form action=<?=$_SERVER['PHP_SELF']?> method="post">
        <label for="new_user"> Введите e-mail
            <input type="email" name="new_user" class="form-control" required>
        </label>
        <label for="new_psw"> Введите пароль нового пользователя
            <input type="password" name="new_user_psw" class="form-control" required>
        </label>
        <button type="submit" class="btn btn-link w-50 btn-lg btn-primary">Добавить пользователя</button>
    </form>


    <a href="../users/<?=$_COOKIE['user_id']?>">Вернуться</a>
    <?php
}