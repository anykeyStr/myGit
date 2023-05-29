<?php
$urlList = [

    '/user' => [
//        Получить список пользователей (массив)
        'GET' => 'UsersController::get_users',
//        Добавить пользователя
        'POST' => 'UsersController::add_user',
//        Обновить пользователя
        'PUT' => 'UsersController::update_user',
    ],

    "/users/$id" => [
        //    Получить JSON-объект с информацией о конкретном пользователе (о себе)
        'GET' => 'UsersController::get_user',
        //        Удалить пользователя (себя)
        'DELETE' => 'UsersController::delete_user',
    ],

    '/login' => [
        //авторизоваться
        'GET' => 'UsersController::login'
    ],


    '/registration' => [
        //зарегистрироваться
        'GET' => 'UsersController::registration'
    ],

    '/reset_password' => [
        //забыл пароль
        'GET' => 'UsersController::reset_password'
    ],

    '/logout' => [
        //выход
        'GET' => 'UsersController::logout'
    ],

    '/admin/user' => [
//        Получить список всех пользователей
        'GET' => 'AdminController::get_users',
//        Обновить пользователя
        'PUT' => 'AdminController::update_user',
    ],

    "/admin/user/$id" => [
        //   информацией о конкретном пользователе
        'GET' => 'AdminController::get_user',
        //        Удалить пользователя
        'DELETE' => 'AdminController::delete_user',
    ],

    '/file' => [
//        Вывести список файлов
        'GET' => 'FileController::list_all_files',
//          Добавить файл
        'POST' => 'FileController::add_file',
//        Переименовать или переместить файл
        'PUT' => 'FileController::update_file',
    ],

    "/file/$id" => [
        //    Получить информацию о конкретном файле
        'GET' => 'FileController::id_file',
        //        Удалить файл
        'DELETE' => 'FileController::delete_file',
    ],

    '/directory' => [
//        Добавить папку (директорию)
        'POST' => 'FileController::add_directory',
//        Переименовать папку
        'PUT' => 'FileController::update_directory',
    ],

    "/directory/$id" => [
        //    Получить информацию о папке (список файлов папки)
        'GET' => 'FileController::id_directory',
        //      Удалить папку
        'DELETE' => 'FileController::delete_directory',
    ],

    "/files/share/$id" =>[
//        Cписок пользователей, имеющих доступ к файлу
        'GET' => 'FileController::shared_users',
    ],

    "/files/share/$id/$user_id" =>[
//        Добавить доступ к файлу пользователю
        'PUT' => 'FileController::add_share',
        //        Прекратить доступ к файлу пользователю
        'DELETE' => 'FileController::delete_share',
    ],


    "/user/search/$email" => [
        'PUT' => 'UsersController::search_user'
    ]



];
