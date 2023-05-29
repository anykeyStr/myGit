@extends('layouts.default')

@section('content')

<h1>Страница контактов</h1>
<p>Адрес: {{ $address }}</p>
<p>Почтовый индекс: {{ $post_code }}</p>
<p>Телефон: {{ $phone }}</p>

    @if (empty($email))
        <p>Адрес электронной почты не указан.</p>
    @else
        <p>Email: {{ $email }}</p>
    @endif

@stop
