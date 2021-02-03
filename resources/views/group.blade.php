@extends('layouts.stats')


@section('tite')
    Группа {{ $group['name'] }}
@endsection


@section('content')

<div class="panel container">
    <a href="/welcome" class="panel-button button"><< назад</a>
</div>


<h1>Группа {{ $group['name'] }}</h1>

<form class="panel container" data-method="group/rename/{{ $group['id'] }}">
    <input type="text" name="name" value="{{ $group['name'] }}">
    <button class="panel-button button">Переименовать группу</button>
    <div class="panel-button button" data-click="group/delete/{{ $group['id'] }}" data-name="name" data-content="{{ $group['name'] }}">Удалить группу</div>
</form>

<h2>Каналы</h2>

<form class="panel container" data-method="group/create">
    <input type="text" name="name" placeholder="название или id нового канала">
    <button class="panel-button button">Добавить канал</button>
</form>


<div class="table container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>img</th>
                <th>Название</th>
                <th>Кол-во видео</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $item)
                <tr data-href="/ch/">
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    
@endsection