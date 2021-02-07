@extends('layouts.stats')


@section('tite')
    {{ $channel['title'] }}
@endsection


@section('content')

<div class="panel container">
    <a href="/gr/{{ $channel['group_id'] }}" class="panel-button button"><< назад</a>
</div>



<h1 class="title">
    <img class="title_ava" src="{{ $channel['medium'] }}" alt="{{ $channel['title'] }}">
    <span>Канал {{ $channel['title'] }} </span>
</h1>


<div class="panel container">
    <!-- 
    <div class="panel-button button" data-click="channel/delete/{{ $channel['id'] }}" data-name="name" data-content="{{ $channel['id'] }}">Удалить канал</div>
    -->
</div>


<h2>Видео</h2>


<div class="table container">
    <table>
        <thead>
            <tr>
                <th>Превью</th>
                <th>Название</th>
                <th>Youtube</th>
                <th>Прирост за 24 часа</th>
                <th>Здесь будут дельты</th>
                <th>Лайки / дизлайки</th>
                <th>Комменты</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $item)
                <tr>
                    <td><img class="videoPik" src="{{ $item['pik'] }}" alt="{{ $item['title'] }}"></td>
                    <td>{{ $item['title'] }}</td>
                    <td><a target="_blank" href="https://youtube.com/video/{{ $item['v_id'] }}">{{ $item['v_id'] }}</a></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



    
@endsection