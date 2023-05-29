<?php
    $query = "SELECT * FROM user";
    $users = $this->request_all($query);
    echo '<b>Список всех пользователей:</b><br>';
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . "/admin/user/";
    foreach ($users as $user) :

?>

<table class="table">
    <tr>
        <th scope="col">id <?=$user['id']?></th>
        <td scope="col"><?=$user['email']?></td>
        <td scope="col"><?=$user['role']?></td>
        <td scope="col"><a href="<?=$url . $user['id']?>">Подробнее</a></td>
        <td scope="col"><a href="../data/update_admin_user.php?update_id=<?=$user['id']?>&update_email=<?=$user['email']?>">Обновить информацию </a></td>
        <td scope="col"><a href="../data/delete_admin_user.php?delete_id=<?=$user['id']?>">Удалить пользователя </a></td>
    </tr>
</table>

<?php
    endforeach;
    echo "<br><a href='../users/{$_COOKIE['user_id']}'> Свернуть список </a>";
?>