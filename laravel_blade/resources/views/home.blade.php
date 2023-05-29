@extends('layouts.default')

@section('content')

<div>
<h1>Добро пожаловать на домашнюю страницу!</h1>
</div>
<div>
<p> Имя: {{ $name }}</p>
<p> Должность: {{ $position }}</p>
<p> Адрес: {{ $address }}</p>

    @if ($age > 18)
        <p> Возраст: {{ $age }}</p>
    @else
        <p>Вы слишком молоды.</p>
    @endif

</div>

@stop
