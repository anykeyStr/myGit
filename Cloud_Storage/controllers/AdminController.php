<?php
class AdminController extends UsersController
{
    public function get_users()
    {
        $user_id = $_COOKIE['user_id'];
        parent::get_user($user_id);
        include_once 'view/admin_profile.php';
        //parent::get_users();

    }

    public function get_user($id)
    {
      //  include_once 'view/admin_profile.php';
        include_once 'view/user_profile_info.php';
        //parent::get_user($id);
    }

    public function update_user($user_id = null, $data)
    {

        $query = "UPDATE user SET password = IF(LENGTH(:password) > 0, :password, password), role = IF(LENGTH(:role) > 0, :role, role) WHERE id = :id";
        $params = ['password' => $data['new_psw'], 'role' => $data['new_role'], 'id' => (int)$data['id']];

        $this->request($query, $params);
        echo 'Даннные пользователя обновлены';
    }

    public function delete_user($id)
    {
        parent::delete_user($id);
    }

}


