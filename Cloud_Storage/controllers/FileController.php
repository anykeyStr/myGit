<?php

/**
 * Работа с файлами.
 */

class FileController extends UsersController
{
//Вывести список файлов
    public function list_all_files()
    {
        $user_id = $_COOKIE['user_id'];
        parent::get_user($user_id);

        $query = "SELECT * FROM files WHERE user_id = :user_id";
        $params = ['user_id' => (int)$user_id];
        $files = $this->request_all($query, $params);

        echo '<h2>Пользователь загрузил следующие файлы:</h2>';
        foreach ($files as $file) {
            echo '<br>' . $file['name'] . "  <a href='../file/{$file['id']}'>Подробнее</a>";
            echo "   <a href='../data/update_file.php?file_id={$file['id']}'>Переименовать / Переместить файл</a>";
            echo "   <a href='../data/delete_file.php?file_id={$file['id']}'>Удалить файл</a>";
            echo '<hr>';
        }

        echo "<br><h3>Папки пользователя:</h3><br>";
        $query = "SELECT * FROM folders WHERE users_folder LIKE :users_folder";
        $params = ['users_folder' => $user_id];
        $dirs = $this->request_all($query, $params);


        foreach ($dirs as $dir) {
            echo $dir['name_folder'] . "<a href='directory/{$dir['id_folder']}'> Список файлов </a>&nbsp <a href='../data/update_directory.php?folder={$dir['name_folder']}'> Переименовать </a> &nbsp<a href='../data/delete_directory.php?del_dir={$dir['id_folder']}'> Удалить </a><br>";
        }

        echo "<br><a href='../users/{$_COOKIE['user_id']}'> Свернуть список </a>";

    }

    //Добавить файл
    public function add_file()
    {
        $id = $_COOKIE['user_id'];

        $path = $_SERVER['DOCUMENT_ROOT'] . "/files/$id/";

        if (!file_exists($path)) {
            if (!mkdir($path)) {
                echo 'Не удалось создать директорию для файлов';
                return;
            }
        }

        if (isset($_FILES['file'])) {
            try {
                $file_name = $_FILES['file']['name'];
                $id_file = hash('md5', $file_name . date("Y-m-d H:i:s"));

                $query = "INSERT INTO files(id, id_file, name , user_id, path, type, created_at) values(null, :id_file, :name , :user_id, :path, :type, :created_at)";
                $params = ['id_file' => $id_file, 'name' => $file_name, 'user_id' => $id, 'path' => $path, 'type' => $_FILES['file']['type'], 'created_at' => date("Y-m-d H:i:s")];

                $this->request($query, $params);
                $upload_success = move_uploaded_file($_FILES['file']['tmp_name'], $path . $id_file);

                if ($upload_success) {
                    echo 'Файл добавлен';
                } else {
                    echo 'Не удалось загрузить файл';
                }

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        parent::get_user($id);
    }

    //        Переименовать или переместить файл
    public function update_file($id = null, $data)
    {
        if($data['replace_file'] == '0') {
            $query = "UPDATE files SET name = IF(LENGTH(:name) > 0, :name, name) WHERE id = :id";
            $params = ['name' => $data['new_filename'], 'id' => (int)$data['file_id']];
            $this->request($query, $params);
            echo 'Файл переименован';
        } else {
            //проверить существует ли каталог
            $query = "SELECT * FROM folders WHERE name_folder LIKE :name_folder AND users_folder LIKE :users_folder ";
            $params = ['name_folder' => $data['new_filename'], 'users_folder' => $data['user_id']];
            $folder = $this->request($query, $params);

            //вывести сообщение о результате
            if($folder) {
                $query = "UPDATE files SET directory = :directory WHERE id = :id";
                $params = ['directory' => $data['new_filename'], 'id' => (int)$data['file_id']];
                $this->request($query, $params);
                //переместить файл
                echo " Файл перемещен в папку " . $data['new_filename'];
            } else {
                echo "Такой папки не существует, создайте ее";
            }
        }


    }


    //    Получить информацию о конкретном файле
    public function id_file($id)
    {
        $id_file = $id;
        $user_id = $_COOKIE['user_id'];
        parent::get_user($user_id);
        $query = "SELECT * FROM files WHERE id = :id";
        $params = ['id' => (int)$id_file];
        $file = $this->request($query, $params);
        echo '<br>';
        echo 'Имя файла: ' . $file['name'] . '<br>';
        echo 'Тип файла: ' . $file['type'] . '<br>';
        echo 'Файл загружен: ' . $file['created_at'] . '<br>';
        echo 'Находится в папке: ' . $file['directory'] . '<br>';
        echo '<hr>';
        echo "<a href='../files/share/{$user_id}'>Кто имеет доступ к файлу </a><br>";
        echo "<a href='../data/add_share_file.php?file_id={$id_file}'>Добавить / Запретить доступ к файлу пользователю </a><br>";


    }

    //        Удалить файл
    public function delete_file($file_id)
    {
        //удаляем файл c HDD
        $query = "SELECT * FROM files WHERE id = :id";
        $params = ['id' => (int)$file_id];
        $file = $this->request($query, $params);
        unlink ($file['path'] . $file['id_file']);

        //удаляем файл с БД
        $query = "DELETE FROM files WHERE id = :id";
        $params = ['id' => $file_id];
        $this->request($query, $params);
        echo " Файл удален \n";

    }

    //        Добавить папку (директорию)
    public function add_directory()
    {
        $user_id = $_POST['user_id'];
        $new_directory = $_POST['new_directory'];
        $path = $_SERVER['DOCUMENT_ROOT'] . "/files/$user_id/$new_directory";

        if (!file_exists($path)) {
            if (!mkdir($path)) {
                echo 'Не удалось создать директорию для файлов';
                return;
            }
            $query = "INSERT INTO folders(id_folder, name_folder, users_folder) values(null, :name_folder, :users_folder)";
            $params = ['name_folder' => $new_directory, 'users_folder' => $user_id];

            $this->request($query, $params);
        }

        echo 'Папка создана';
    }

    //        Переименовать папку
    public function update_directory($id = null, $data)
    {
        $old_folder_path = $_SERVER['DOCUMENT_ROOT'] . "/files/{$data['user_id']}/{$data['folder']}";
        $new_folder_path = $_SERVER['DOCUMENT_ROOT'] . "/files/{$data['user_id']}/{$data['new_folder_name']}";

        rename($old_folder_path, $new_folder_path);

        $query = "UPDATE folders SET name_folder = :new_name_folder WHERE users_folder = :users_folder AND name_folder LIKE :name_folder";
        $params = ['new_name_folder' => $data['new_folder_name'], 'users_folder' => (int)$data['user_id'], 'name_folder' => $data['folder']];
        $this->request($query, $params);

        $query = "UPDATE files SET directory = :directory WHERE directory LIKE :old_directory";
        $params = ['directory' => $data['new_folder_name'], 'old_directory' => $data['folder']];
        $this->request($query, $params);

        echo 'Папка переименована';

    }

    //    Получить информацию о папке (список файлов папки)
    public function id_directory($id_folder)
    {
        echo "В папке содержатся следующие файлы: ";

        $query = "SELECT * FROM folders WHERE id_folder = :id_folder";
        $params = ['id_folder' => (int)$id_folder];
        $folder = $this->request($query, $params);
        $folder_name = $folder['name_folder'];

        $query = "SELECT * FROM files WHERE directory LIKE :directory";
        $params = ['directory' => $folder_name];
        $files = $this->request_all($query, $params);


        foreach ($files as $file) {
            echo 'Имя файла: ' . $file['name'] . '<br>';
        }

        echo "<br><a href='../users/{$_COOKIE['user_id']}'> Назад </a>";
    }

    //      Удалить папку
    public function delete_directory($id_folder)
    {
        //удаляем папку c HDD
        $query = "SELECT * FROM folders WHERE id_folder = :id_folder";
        $params = ['id_folder' => (int)$id_folder];
        $file = $this->request($query, $params);
        $path =  $_SERVER['DOCUMENT_ROOT'] . "/files/{$file['users_folder']}/{$file['name_folder']}";

        if (file_exists($path)) {
            rmdir($path);
        }

        //удаляем папку с БД
        $query = "DELETE FROM folders WHERE name_folder LIKE :name_folder";
        $params = ['name_folder' => $file['name_folder']];
        $this->request($query, $params);

        //удаляем файл с БД
        $query = "DELETE FROM files WHERE directory LIKE :directory";
        $params = ['directory' => $file['name_folder']];
        $this->request($query, $params);
        echo " Каталог удален  \n";
    }

    //        Cписок пользователей, имеющих доступ к файлу
    public function shared_users($user_id)
    {

        $query = "SELECT * FROM shared WHERE own_user_id LIKE :own_user_id";
        $params = ['own_user_id' => $user_id];
        $users = $this->request_all($query, $params);

        foreach ($users as $user){
            $user_share_id = $user['user_id'];
            $query = "SELECT * FROM user WHERE id = :id";
            $params = ['id' => (int)$user['user_id']];
            $user_name = $this->request($query, $params);
            echo "User {$user_name['email']} имеет доступ к этому файлу";
        }


        echo "SHARA HUYRA";
    }

    //        Добавить доступ к файлу пользователю
    public function add_share($id = null, $data)
    {
        echo 'FILE IS SHARED';
        $query = "INSERT INTO shared(file_id, user_id, own_user_id) values(:file_id, :user_id, :own_user_id)";
        $params = ['file_id' => $data['file_id'], 'user_id' => $data['user_share_id'], 'own_user_id'=>$data['user_own_id']];

        $this->request($query, $params);
    }

    //        Прекратить доступ к файлу пользователю
    public function delete_share($id = null, $data)
    {
        echo 'SHARED ID DELETED';
        $query = "DELETE FROM shared WHERE user_id LIKE :user_id";
        $params = ['user_id' => $data['user_share_id']];

        $this->request($query, $params);
    }
}