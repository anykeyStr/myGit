<?php
if (!isset($_SESSION)) session_start ();

class UsersController extends DatabaseController
{

    //регистрация
    public function registration()
    {
        include_once 'view/registration_form.php';
    }

    //авторизация
    public function login()
    {
        include_once 'view/login_form.php';

    }

    //выход
    public function logout()
    {
        foreach ($_COOKIE as $name=>$value){
            setcookie($name, "", time() - 3600);
        }
//        setcookie("isAuthorization", "", time() - 3600);
        header("Location: login");

    }

    //забыл пароль
    public function reset_password()
    {
        echo 'забыл пароль';
        //include_once 'view/reset_psw_form.php';
    }

    // Вывод конкретного пользователя
    public function get_user($user_id)
    {

        include_once 'view/user_profile.php';
    }

    //добавить пользователя
    public function add_user($id = null, $data)
    {
        $new_user = $data['new_user'];
        $new_user_psw = $data['new_user_psw'];

        //сперва проверяем, есть ли такой пользователь
        $query = "SELECT * FROM user WHERE email LIKE :email";
        $params = ['email' => $new_user];
        $result = $this->request($query, $params);

        //если $result пустой, значит такой email отсутствует, добавляем в БД
        if (!$result) {
            $query = "INSERT INTO user(id, email, password, role) values(null, :email, :password, :role)";
            $params = ['email' => $new_user, 'password' => $new_user_psw, 'role' => 'user'];
            $this->request($query, $params);
            echo 'пользователь добавлен';
        } else {
            echo 'Такой пользователь уже существует';
                }

    }

    //получить список всех пользователей
    public function get_users()
    {

        $query = "SELECT * FROM user";
        $users = $this->request_all($query);
        echo '<h2>В системе зарегистрированы следующие пользователи:</h2>';
        foreach ($users as $user) {
            echo $user['email'] . '<br>';
        }
        echo "<br><a href='../users/{$_COOKIE['user_id']}'> Назад </a>";
    }

    //обновить пользователя
    public function update_user($id = null, $data)
    {
        $id = (int)$data['id'];
        $new_password = $data['new_psw'];
        //выполняем запрос
        $query = "UPDATE user SET password = :password WHERE id = :id";
        $params = ['password' => $new_password,'id' => $id];
        $this->request($query, $params);
        echo 'Пароль изменен';

    }

    //удалить пользователя
    public function delete_user($id)
    {
        //выполняем запрос
        $query = "DELETE FROM user WHERE id = :id";
        $params = ['id' => $id];
        $this->request($query, $params);
        echo "пользователь id = $id удален \n";

    }

    //find user
    public function search_user($id = null, $data)
    {
        $email = $data['user_share'];
        $user_own_id = $data['user_id'];
        $file_id = $data['file_id'];

        $query = "SELECT * FROM user WHERE email LIKE :email";
        $params = ['email' => $email];
        $result = $this->request($query, $params);

        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
        $url .= "/files/share/{$user_own_id}/{$result['id']}";

        if($data['action'] == 'add' ) {
            $method_request = 'PUT';
        } if($data['action'] == 'delete' ) {
            $method_request = 'DELETE';
        }

        $data = [
            'user_own_id' => $user_own_id,
            'user_share_id' => $result['id'],
            'file_id' => $file_id,
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method_request, // Метод запроса
            CURLOPT_POSTFIELDS => http_build_query($data) // Данные для отправки
        ];

        // Инициализация cURL-сессии
        $ch = curl_init();
        curl_setopt_array($ch, $options);

// Выполнение запроса
        $response = curl_exec($ch);


    }









//
//    public function reset_password()
//    {
//        include_once 'view/reset_psw_form.php';
//    }
//
//
//
//    public static function list_user()
//    {
//        include_once 'view/user_view.php';
//    }
//
}