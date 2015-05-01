@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {{ $match->team->name }} VS. {{ $match->opponent->name }}
            <br>
            @foreach($match->rounds as $round)
                <strong>Round:</strong> {{ $round->id }} <br>
                <strong>Map:</strong> {{ $round->map->name }} <br>
                <strong>Round scores:</strong> <br>
                @foreach($round->scores as $roundScore)
                    Score Home: {{ $roundScore->score_home }} <br>
                    Score Guest: {{ $roundScore->score_guest }} <br>
                    <hr>
                @endforeach
            @endforeach
        </div>
    </div>
</div>

@endsection