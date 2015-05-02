@extends('app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Create new match!</h1>
            <form action="/">
                <div class="form-group">
                    <label for="team">Choose team</label>
                    <select class="form-control" id="team" name="team">
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="opponent">Choose opponent</label>
                    <select class="form-control" id="opponent" name="opponent">
                        @foreach($opponents as $opponent)
                            <option value="{{ $opponent->id }}">{{ $opponent->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="game">Choose game</label>
                    <select class="form-control" id="game" name="game">
                        @foreach($games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endforeach
                    </select>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#round1" data-toggle="tab">Round 1</a></li>
                    <li><a href="#round2" data-toggle="tab">Round 2</a></li>
                    <li><a href="#round3" data-toggle="tab">Round 3</a></li>
                    <li><a href="#round4" data-toggle="tab">Round 4</a></li>
                    <li><a href="#round5" data-toggle="tab">Round 5</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="round1">
                        <br/>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Team score" />
                            <br/>
                            <input type="text" class="form-control" placeholder="Opponent score" />
                        </div>
                        <div class="form-group">
                            <label for="round-info">Round notes</label>
                            <textarea class="form-control" name="round-info" id="round-info" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="tab-pane" id="round2">Round2</div>
                    <div class="tab-pane" id="round3">Round3</div>
                    <div class="tab-pane" id="round4">Round4</div>
                    <div class="tab-pane" id="round5">Round5</div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection