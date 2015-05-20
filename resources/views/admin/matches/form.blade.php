@extends('app-admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8" id="match-form">
                {!! Form::open(['id' => 'match-form']) !!}
                <h3>1. Match information</h3>
                <hr/>
                <div class="form-group">
                    <label for="team">Choose team</label>
                    <select class="form-control" id="team" name="team" data-bind="value: team_id">
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="opponent">Choose opponent</label>
                    <select class="form-control" id="opponent" name="opponent" data-bind="value: opponent_id">
                        @foreach($opponents as $opponent)
                            <option value="{{ $opponent->id }}">{{ $opponent->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="game">Choose game</label>
                    <select class="form-control" id="game" name="game" data-bind="value: game_id">
                        @foreach($games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endforeach
                    </select>
                </div>
                <h3>2. Match Rounds</h3>
                <hr/>
                <a href="#" data-bind="click: addRound"><i class="fa fa-fw fa-plus-circle"></i> Add a round</a>
                <ul class="nav nav-pills" id="rounds" data-bind="foreach: rounds">
                    <li><a data-toggle="tab"
                           data-bind="text: 'Round ' + ($index() + 1), attr: { href: '#round' + $index() }"></a></li>
                </ul>
                <div class="tab-content" data-bind="foreach: rounds">
                    <div class="tab-pane" data-bind="attr: { id: 'round' + $index() }">
                        <br/>

                        <div class="form-inline" data-bind="foreach: scores">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Team score" data-bind="value: home"/>
                                <input type="text" class="form-control" placeholder="Opponent score" data-bind="value: guest"/>
                                <select class="form-control" name="map">
                                    @foreach($maps as $map)
                                        <option value="{{ $map->id }}">{{ $map->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-danger" data-bind="click: $parent.removeScore"><i
                                            class="fa fa-fw fa-minus-circle"></i></button>
                            </div>
                        </div>
                        <button class="btn btn-success" data-bind="click: addScore"><i
                                    class="fa fa-fw fa-plus-circle"></i> Add score
                        </button>
                        <br/>

                        <div class="form-group">
                            <label for="round-info">Round notes</label>
                            <textarea class="form-control" name="round-info" id="round-info" rows="4"
                                      data-bind="text: notes"></textarea>
                        </div>
                    </div>
                </div>
                <h3>3. Match links</h3>
                <hr/>
                <button class="btn btn-success" type="submit">Save</button>
                {!! Form::close() !!}
            </div>
            <div class="col-md-4">
                <div class="block">
                    <h3>
                        Text block help
                        <small>Subtitle of text block</small>
                    </h3>
                    <div class="block-body">
                        Note that views which extend a Blade layout simply override sections from the layout. Content of
                        the layout can be included in a child view using the directive in a section, allowing you to
                        append to the contents of a layout section such as a sidebar or footer.
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection