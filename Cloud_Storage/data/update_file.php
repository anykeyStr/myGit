<?php



if (isset($_POST['new_filename']) && !empty($_POST['new_filename'])) {
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
    $user_id = $_COOKIE['user_id'];
    $url .= "/file";

// Данные для отправки в теле запроса (если необходимо)
    $data = [
        'file_id' => $_POST['file_id'],
        'new_filename' => $_POST['new_filename'],
        'user_id' => $user_id,
    ];

    //переименовываем файл или перемещаем
    if (isset($_POST['replace_file'])) {
        $data['replace_file'] = true;
    } else {
        $data['replace_file'] = false;
    }

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
        <label for="new_filename"> Введите новое имя файла
            <input type="text" name="new_filename" class="form-control">
            <input type="hidden" name="file_id" value=<?=$_GET['file_id']?> class="form-control">
        </label>
        <button class="btn btn-link" type="submit" class="w-50 btn btn-lg btn-primary" name="rename_file">Изменить имя файла</button>
        <button class="btn btn-link" type="submit" class="w-50 btn btn-lg btn-primary" name="replace_file">Переместить в папку</button>
    </form>




    <a href="../users/<?=$_COOKIE['user_id']?>">Вернуться</a>
    <?php
}
