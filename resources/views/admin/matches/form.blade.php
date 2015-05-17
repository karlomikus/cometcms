@extends('app-admin')

@section('content')

<div class="container" ng-controller="MatchesController">
    <div class="row">
        <div class="col-md-8">
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
                    <li><a href="#"><i class="glyphicon glyphicon-plus"></i> Add round</a></li>
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
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="block">
                <h3>
                    Text block help
                    <small>Subtitle of text block</small>
                </h3>
                <div class="block-body">
                    Note that views which extend a Blade layout simply override sections from the layout. Content of the layout can be included in a child view using the directive in a section, allowing you to append to the contents of a layout section such as a sidebar or footer.
                </div>
            </div>
        </div>
    </div>
</div>

@endsection