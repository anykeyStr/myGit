<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    // Проверяем, что обязательные поля email и password переданы
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo 'Учетные данные не были переданы';
        exit;
    }

    // Автозагрузка классов контроллеров
    spl_autoload_register(function ($class) {
        require_once 'controllers/' . $class . '.php';
    });

    //экземпляр юзера для проверки в БД
    $db = new UsersController();

    //создаем запрос на проверку в БД с переданными параметрами из формы в переменной POST
    $query = "SELECT * FROM user WHERE email LIKE :email AND password LIKE :password";
    $params = ['email' => $_POST['email'], 'password' => $_POST['password']];
    $result = $db->request($query, $params);

//если запрос выполнен успешно и получили данные пользователя
    if(!empty($result)) {
        setcookie('user_id', $result['id']);
        setcookie('isAuthorization', session_id());
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . "/users/{$result['id']}";

        // URL, куда отправляется запрос
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET' // Метод запроса
        ];

        // Инициализация cURL-сессии
        $ch = curl_init();
        curl_setopt_array($ch, $options);

        // Выполнение запроса
        $response = curl_exec($ch);

        // Обработка ответа и ошибок
        if ($response === false) {
            echo curl_error($ch);
        } else {
            // Вывод ответа
            echo $response;
        }

        // Завершение cURL-сессии
        curl_close($ch);


    } else {
        echo 'Учетная запись не найдена, зарегистрируйтесь';
        echo '<a href="/registration">Регистрация</a>';
    }





