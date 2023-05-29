<?php
//for admin view
echo "<h2>Профиль пользователя  ID {$id}</h2> Успешная авторизация";

$db = new DatabaseController();
$query = "SELECT * FROM user WHERE id = :id";
$params = ['id' => $id];
$result = $db->request($query, $params);
$url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . "/users/";
//    $id = $_COOKIE['user_id'];

//if ($result['role'] == 'admin') {
//    echo "<h3 style='background-color: #5bcbe7'>Вы являетесь Администратором</h3>";
//    echo "<a href='../admin/user'>Cписок всех пользователей / Действия </a>";
//}

?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Статус</th>
        <th scope="col">ID</th>
        <th scope="col">Логин</th>
        <th scope="col">Роль</th>
        <th scope="col"> </th>
        <th scope="col"> </th>


    </tr>
    </thead>
    <tbody>

    <tr>
        <th scope="row"> Просмотр профиля пользователя </th>
        <td> <?=$result['id']?></td>
        <td> <?=$result['email']?></td>
        <td> <?=$result['role']?></td>
        <td>
            <a href="/logout"> Выйти </a>
        </td>
    </tr>


    </tbody>
</table>
<hr>
<a href="<?=$url . $_COOKIE['user_id']?>">Вернуться</a>

