<?php
    spl_autoload_register(function ($class) {
        require_once 'controllers/' . $class . '.php';
    });

    if (isset($_GET['new_email']) && isset($_GET['new_password'])) {
                $email = $_GET['new_email'];
                $password = $_GET['new_password'];

                if (!empty($email) && !empty($password)) {
                    // Проверяем правильность формата email
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo 'Неверный формат электронной почты';
                        exit;
                    }

                    //        подкллючаемся к БД

                    $db = new DatabaseController();

                    // Проверяем, есть ли уже такой email в базе данных
                    $query = "SELECT * FROM user WHERE email LIKE :email";
                    $params = ['email' => $email];
                    $result = $db->request($query, $params);


                    //если $result пустой, значит такой email отсутствует, добавляем в БД
                    if (!$result) {
                        //добавляем нового юзера в бд
                        $query = "INSERT INTO user(id, email, password, role) values(null, :email, :password, :role)";
                        $params = ['email' => $email, 'password' => $password, 'role' => 'user'];
                        $db->request($query, $params);

                        //создаем сессию авторизации
                        if (!isset($_SESSION)) {
                            session_start();
                            setcookie('isAuthorization', session_id());
                        }

                        //получаем id нового юзера
                        $query = "SELECT * FROM user WHERE email LIKE :email";
                        $params = ['email' => $email];
                        $result = $db->request($query, $params);

                        //переходим в профиль юзера
                        $_SESSION['user_id'] = $result['id'];
                        header("Location: users/{$result['id']}");
                    }
                    else {
                        echo "<h1>Учетная запись существует, авторизуйтесь</h1>";
                    }

                } else {
                    echo "Логин и пароль не могут быть пустыми";
                }

            } else {
                echo "Заполните форму регистрации";
            }