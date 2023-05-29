<?php
    //Хедер, просто html
    include_once 'view/header.php';

    // Автозагрузка классов контроллеров
    spl_autoload_register(function ($class) {
        require_once 'controllers/' . $class . '.php';
    });


    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $requestUrl = $_SERVER['REQUEST_URI'];

    //если заходим на сервер, то строка меняется на login для дальнейшей обработки
    $requestUrl = ($requestUrl === '/') ? '/login' : $requestUrl;

    //в зависимости от метода парсим нашу строку для вызова соответсующего метода из массива в файле конфиг.пхп
    switch ($requestMethod) {
        case 'GET':
            // с методом get, если есть число, то это может быть только id
            $id = filter_var($requestUrl, FILTER_SANITIZE_NUMBER_INT);
            break;
        case 'POST':
            // если не метод get, то все данные передаются curl'ом и попадают в $data
            parse_str(file_get_contents('php://input'), $data);
            // действия для метода POST
            break;
        case 'PUT':
            // если не метод get, то все данные передаются curl'ом и попадают в $data
            parse_str(file_get_contents('php://input'), $data);
            $pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/'; // паттерн для поиска email
            preg_match($pattern, $requestUrl, $email); // ищем email в строке и сохраняем его в $matches

            if (!empty($email)) {
                $email = $email[0]; // первый элемент массива $matches содержит найденный email
            }
            if(isset($data['user_own_id']) && ($data['user_share_id']) ) {
                $id = $data['user_own_id'];
                $user_id = $data['user_share_id'];
            }
            // действия для метода PUT
            break;
        case 'DELETE':
            // если не метод get, то все данные передаются curl'ом и попадают в $data
            parse_str(file_get_contents('php://input'), $data);
            $id = $data['id'];
            if(isset($data['user_own_id']) && ($data['user_share_id']) ) {
                $id = $data['user_own_id'];
                $user_id = $data['user_share_id'];
            }
            // действия для метода DELETE
            break;
}






    require_once "data/config.php";

    foreach ($urlList as $url => $methods) {
        if ($url === $requestUrl && isset($methods[$requestMethod])) {
            $controllerAction = $methods[$requestMethod];
            list($controller, $action) = explode('::', $controllerAction);
            require_once 'controllers/' . $controller . '.php';
            $controllerObj = new $controller();
            $controllerObj->$action($id, $data);
            exit;
        }
    }

    // Если URL не найден в списке, выведите ошибку 404
    http_response_code(404);
    echo 'Страница не найдена';