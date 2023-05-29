<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Book;

class BookController extends Controller
{
    // Показать форму
    public function index()
    {
        return view('form');
    }

    public function store(Request $request)
    {

            $validatedData = $request->validate([
                'title' => 'required|string|max:255|unique:books',
                'author' => 'required|string|max:100',
                'genre' => 'required|string'
            ]);

            Book::create($validatedData);

            return response()->json('Book is successfully validate and added into base');


    }
}
