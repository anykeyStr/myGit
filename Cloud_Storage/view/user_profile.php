<?php

echo "<h2>Профиль пользователя  ID {$user_id}</h2> Успешная авторизация ";

$db = new DatabaseController();
$query = "SELECT * FROM user WHERE id = :id";
$params = ['id' => $user_id];
$result = $db->request($query, $params);

if ($result['role'] == 'admin') {
    echo "<h3 style='background-color: #5bcbe7'>Вы являетесь Администратором</h3>";
    echo "<a href='../admin/user'>Cписок всех пользователей / Действия </a>";
}

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
        <th scope="row"> Авторизован </th>
        <td> <?=$result['id']?></td>
        <td> <?=$result['email']?></td>
        <td> <?=$result['role']?></td>
        <td>
            <a href="/logout"> Выйти </a>
        </td>
    </tr>

    <tr><hr>
        <th scope="row"> Действия </th>
        <td><a href="../user">Получить список пользователей </a></td>
        <td><a href="../data/add_user.php">Добавить пользователя </a></td>
        <td> <a href="../data/update_user.php">Изменить свои данные </a> </td>
        <td><a href="../data/delete_user.php">Удалить свой аккаунт </a></td>

    </tr>
    </tbody>
</table>
<hr>

Загрузите файлы


<form action="../file" enctype="multipart/form-data" method="post">
    <input type="file" name="file" name="file">
    <br><br>
    <input type="submit" value="Загрузить" class="btn btn-success">
</form>

<a href="../file">Вывести список файлов</a>
&nbsp;
&nbsp;
<a href="../data/add_directory.php">Создать папку (директорию) </a>


