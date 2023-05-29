<?php
include_once '../view/header.php';


//проверяем даннные обновляемого пользователя
if(isset($_GET['update_id']) && !empty(isset($_GET['update_id']))) {
    $update_id = $_GET['update_id'];
    $update_email= $_GET['update_email'];
}



if (isset($_POST['update_user']) && !empty($_POST['update_user'])) {
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
//    $id = $_COOKIE['user_id'];
    $url .= "/admin/user";

// Данные для отправки в теле запроса (если необходимо)
    $data = [
        'id' => $_POST['update_user'],
        'new_psw' => $_POST['new_psw'],
        'new_role' => $_POST['new_role'],
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
    Изменить данные пользователя <?=$update_email?>
    <form action=<?=$_SERVER['PHP_SELF']?> method="post">
        <label for="new_psw"> Изменить пароль
            <input type="text" name="new_psw" class="form-control">
        </label>
        <br>
        <label for="new_role"> Изменить права доступа: user или admin
            <input type="text" name="new_role" class="form-control">
        </label>
        <br>
        <button class="btn btn-link" type="submit" class="w-50 btn btn-lg btn-primary" name="update_user" value="<?=$update_id?>">Обновить данные</button>
    </form>

    <br>
    <a href="../users/<?=$_COOKIE['user_id']?>">Вернуться</a>
    <?php
}