
<?php
if (isset($_POST['user_share']) && !empty($_POST['user_share'])) {
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
//    $id = $_COOKIE['user_id'];
    $url .= "/user/search/{$_POST['user_share']}";

// Данные для отправки в теле запроса (если необходимо)
    $data = [
        'user_id' => $_COOKIE['user_id'],
        'user_share' => $_POST['user_share'],
        'file_id' => $_POST['file_id'],
        'action' => $_POST['action'],
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
        <label> Введите email пользователя, которому предоставить доступ
            <input type="email" name="user_share" class="form-control">
            <input type="hidden" name="file_id" value="<?=$_GET['file_id']?>" class="form-control">
<!--            <input type="hidden" name="action" value="add" class="form-control">-->
        </label>
        <button class="btn btn-link" type="submit" class="w-50 btn btn-lg btn-primary" name="action" value="add" >Дать доступ</button>
        <button class="btn btn-link" type="submit" class="w-50 btn btn-lg btn-primary" name="action" value="delete" >Удалить доступ</button>
    </form>


    <a href="../users/<?=$_COOKIE['user_id']?>">Вернуться</a>
    <?php
}

