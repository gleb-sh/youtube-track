@extends('layouts.stats')


@section('title')
    Настройки
@endsection


@section('content')

<h1>Настройки</h1>

<div class="panel container">
    <a href="/welcome" class="panel-button button"><< на главную</a>
</div>

<div class="container settings">
    <form data-method="settings">
        <p>Нижний порог вывода</p>
        <input type="number" min="0" name="in_table" value="{{ $set['in_table'] }}">
        <p>Дни недостижения до прекращений отслеживания</p>
        <input type="number" min="1" name="in_check" value="{{ $set['in_check'] }}">
        <button class="button">Сохранить</button>
    </form>
</div>

@endsection