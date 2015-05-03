@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h3>Matches</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>Versus</th>
                        <th>Result</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matches as $match)
                        <tr>
                            <td>{{ $match->game }}</td>
                            <td>{{ $match->team }} VS. <strong>{{ $match->opponent }}</strong></td>
                            <td>{{ $match->score_home }} : {{ $match->score_guest  }}</td>
                            <td><a href="/match/{{ $match->id }}">More info</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection