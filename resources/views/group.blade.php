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

<form class="panel container" data-method="channel/add">
    <input type="text" name="name" placeholder="id нового канала">
    <input type="hidden" name="group" value="{{ $group['id'] }}">
    <button class="panel-button button">Добавить канал</button>
</form>


<div class="table container">
    <table>
        <thead>
            <tr>
                <th>Превью</th>
                <th>Название</th>
                <th>Youtube ID</th>
                <th>Подписчиков</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $item)
                <tr>
                    <td><img src="{{ $item['medium'] }}" alt="{{ $item['title'] }}"></td>
                    <td><a href="/ch/{{ $item['id'] }}">{{ $item['title'] }}</a></td>
                    <td><a target="_blank" href="https://youtube.com/channel/{{ $item['c_id'] }}">{{ $item['c_id'] }}</a></td>
                    <td>{{ $item['subs_count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    
@endsection