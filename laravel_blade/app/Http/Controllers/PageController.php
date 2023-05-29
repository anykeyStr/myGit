<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function home()
    {
        $data = [
        'name' => 'Ivan',
        'age' => 17,
        'position' => 'Developer',
        'address' => 'Russia, Volgograd',
        'title_text' => 'Домашняя'
    ];

    return view('home', $data);
    }

    public function contacts()
    {
            $data = [
        'address' => 'Russia, Volgograd',
        'post_code' => '12345',
        'email' => 'Ivan@mail.com',
        'phone' => '+7123456789',
        'title_text' => 'Контакты'
    ];

    return view('contacts', $data);
    }
}
