@extends('layouts.stats')


@section('title')
    {{ $channel['title'] }}
@endsection


@section('content')

<div class="panel container">
    <a href="/gr/{{ $channel['group_id'] }}" class="panel-button button"><< назад</a>
</div>



<h1 data-id="{{ $channel['id'] }}" class="title">
    <img class="title_ava" src="{{ $channel['medium'] }}" alt="{{ $channel['title'] }}">
    <span>Канал {{ $channel['title'] }}</span>
</h1>


<div class="panel container">
    <div class="panel-button button" data-click="channel/delete/{{ $channel['id'] }}" data-name="name" data-content="{{ $channel['id'] }}">Удалить канал</div>
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
                <!-- 
                <th>Здесь будут дельты</th>
                -->
                @for ($i = 1; $i < 25; $i++)
                    <th><span>с @if ( ($header + $i - 1) < 24 )
                        {{ $header + $i - 1 }}
                    @else
                        {{ $header + $i -1 - 24 }}
                    @endif:00<br>по 
                        @if ( ($header + $i ) < 24 )
                            {{ $header + $i }}
                        @else
                            {{ $header + $i - 24 }}
                        @endif
                        :00</span>
                    </th>
                @endfor
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
                    <td>
                        @isset($item['view_up'])
                           {{ $item['view_up'] }}
                        @endisset
                    </td>
                    @for ($i = 1; $i < 25; $i++)
                        <td data-videoid="{{ $item['id'] }}"
                            data-timeto="@if ( ($header + $i ) < 24 )@if ( ($header + $i) < 10 ){{ '0' . ($header + $i) }}@else{{ $header + $i }}@endif
                            @else
                            @if ( ($header + $i - 24) < 10 ){{ '0' . ($header + $i - 24) }}@else{{ $header + $i - 24 }}@endif
                            @endif">0</td>
                    @endfor
                    <td>
                        @if (isset ($item['like_count'] ) && isset($item['dislike_count']) && $item['dislike_count'] != 0 ) 
                            {{  round( $item['like_count'] / $item['dislike_count'], 2) }}
                        @endif
                    </td>
                    <td>
                        @isset($item['comment_count'])
                            {{ $item['comment_count'] }}
                        @endisset
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="/js/stats.js"></script>

    
@endsection