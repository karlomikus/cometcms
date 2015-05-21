@extends('app-admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12" id="match-form">
                {!! Form::open(['id' => 'match-form']) !!}
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="form-subtitle">Match information</h4>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="team">Choose team</label>
                                <select class="form-control" id="team" name="team" data-bind="value: team_id">
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="opponent">Choose opponent</label>
                                <select class="form-control" id="opponent" name="opponent" data-bind="value: opponent_id">
                                    @foreach($opponents as $opponent)
                                        <option value="{{ $opponent->id }}">{{ $opponent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="game">Choose game</label>
                            <select class="form-control" id="game" name="game" data-bind="value: game_id">
                                @foreach($games as $game)
                                    <option value="{{ $game->id }}">{{ $game->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="form-subtitle">Match games</h4>
                    </div>
                    <div class="col-md-10">
                        <a href="#" class="btn btn-success" data-bind="click: addRound"><i
                                    class="fa fa-fw fa-plus-circle"></i> Add a round</a>
                        <ul class="nav nav-pills nav-rounds" id="rounds" data-bind="foreach: rounds">
                            <li><a data-toggle="tab"
                                   data-bind="text: 'Round ' + ($index() + 1), attr: { href: '#round' + $index() }"></a></li>
                        </ul>
                        <div class="tab-content rounds-content" data-bind="foreach: rounds">
                            <div class="tab-pane" data-bind="attr: { id: 'round' + $index() }">
                                <div class="row">
                                    <div class="col-md-3"><label>Home score</label></div>
                                    <div class="col-md-3"><label>Opponent score</label></div>
                                    <div class="col-md-4"><label>Map</label></div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div data-bind="foreach: scores">
                                    <div class="row row-score">
                                        <div class="col-md-3"><input type="text" class="form-control" placeholder="Team score"
                                                                     data-bind="value: home"/></div>
                                        <div class="col-md-3"><input type="text" class="form-control"
                                                                     placeholder="Opponent score"
                                                                     data-bind="value: guest"/></div>
                                        <div class="col-md-4"><select class="form-control" name="map">
                                                @foreach($maps as $map)
                                                    <option value="{{ $map->id }}">{{ $map->name }}</option>
                                                @endforeach
                                            </select></div>
                                        <div class="col-md-2 text-right">
                                            <button class="btn btn-danger" data-bind="click: $parent.removeScore"><i
                                                        class="fa fa-fw fa-minus-circle"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-info pull-right" data-bind="click: addScore"><i
                                                    class="fa fa-fw fa-plus-circle"></i> Add score
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="round-info">Round notes</label>
                            <textarea class="form-control" name="round-info" id="round-info" rows="3"
                                      data-bind="text: notes"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success" type="submit">Save</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection