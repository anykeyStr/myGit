<?php



if (isset($_POST['new_folder_name']) && !empty($_POST['new_folder_name'])) {
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
//    $id = $_COOKIE['user_id'];
    $url .= "/directory";

// Данные для отправки в теле запроса (если необходимо)
    $data = [
        'user_id' => $_COOKIE['user_id'],
        'folder' => $_POST['folder'],
        'new_folder_name' => $_POST['new_folder_name'],
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
        <label for="new_filename"> Введите новое имя папки
            <input type="text" name="new_folder_name" class="form-control">
            <input type="hidden" name="folder" value=<?=$_GET['folder']?> class="form-control">
        </label>
        <button class="btn btn-link" type="submit" class="w-50 btn btn-lg btn-primary">Переименовать папку</button>
    </form>


    <a href="../users/<?=$_COOKIE['user_id']?>">Вернуться</a>
    <?php
}
