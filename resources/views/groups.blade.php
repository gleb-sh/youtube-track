@extends('layouts.stats')


@section('tite')
    
@endsection

@section('content')

<h1>Добро пожаловать!</h1>

<form class="panel container" data-method="group/create">
    <input type="text" name="name" placeholder="название новой группы">
    <button class="panel-button button">Добавить группу</button>
</form>

<div class="table container">
    <table>
        <thead>
            <tr>
                <th>Название группы</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groups as $item)
                <tr data-href="/gr/{{ $item['id'] }}">
                    <td> {{ $item['name'] }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    
@endsection