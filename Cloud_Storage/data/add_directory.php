<?php


if (isset($_POST['new_directory']) && !empty($_POST['new_directory'])) {

    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
    $url .= "/directory";

// Данные для отправки в теле запроса (если необходимо)
    $data = [
        'user_id' => $_COOKIE['user_id'],
        'new_directory' => $_POST['new_directory'],
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
    <h2>Создание новой директории</h2>
    <form action=<?=$_SERVER['PHP_SELF']?> method="post">
        <label for="new_directory"> Напишите название нового каталога
            <input type="text" name="new_directory" class="form-control" required>
        </label>
        <button class="btn btn-link" type="submit" class="w-50 btn btn-lg btn-primary">Создать папку</button>
    </form>


    <a href="../users/<?=$_COOKIE['user_id']?>">Вернуться</a>
    <?php
}
