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






    
@endsection