@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="match-form">
                {!! Form::open(['id' => 'match-form', 'class' => 'admin-form']) !!}
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="game">Choose game</label>
                                    <select class="form-control" id="game" name="game" data-bind="value: game_id, options: games, optionsText: 'name', optionsValue: 'game_id'">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event">Select event</label>
                                    <select class="form-control" id="event" name="event">
                                        <option value="0">The International 2015</option>
                                        <option value="0">The Summit 3</option>
                                        <option value="0">Dreamhack</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"><h4 class="form-subtitle">Participants</h4></div>
                    <div class="col-md-10">
                        TODO
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="form-subtitle">Match games</h4>
                    </div>
                    <div class="col-md-10">
                        <div class="match-form-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><span class="label" data-bind="text: outcome, css: outcomeClass"></span> <!--ko text: finalScore--><!--/ko--> <small data-bind="text: matchRounds"></small></h5>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="#" class="btn btn-sm btn-success" data-bind="click: addRound"><i
                                                class="fa fa-fw fa-plus-circle"></i> Add game</a>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-pills nav-rounds" id="rounds" data-bind="foreach: rounds">
                            <li data-bind="attr: {class: $index() == 0 ? 'active' : ''}"><a data-toggle="tab"
                                   data-bind="text: 'Game ' + ($index() + 1), attr: { href: '#round' + $index() }"></a></li>
                        </ul>
                        <div class="tab-content rounds-content" data-bind="foreach: rounds">
                            <div class="tab-pane" data-bind="attr: { id: 'round' + $index() }, css: $index() == 0 ? 'active' : ''">
                                <div class="form-group">
                                    <label for="map">Map</label>
                                    <select class="form-control" name="map" id="map" data-bind="value: map_id">
                                        @foreach($maps as $map)
                                            <option value="{{ $map->id }}">{{ $map->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-5"><label>Home score</label></div>
                                    <div class="col-md-5"><label>Opponent score</label></div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div data-bind="foreach: scores">
                                    <div class="row row-score">
                                        <div class="col-md-5"><input type="text" class="form-control" placeholder="Team score"
                                                                     data-bind="value: home"/></div>
                                        <div class="col-md-5"><input type="text" class="form-control"
                                                                     placeholder="Opponent score"
                                                                     data-bind="value: guest"/></div>
                                        <div class="col-md-2 text-right">
                                            <button class="btn btn-danger" data-bind="click: $parent.removeScore"><i
                                                        class="fa fa-fw fa-lg fa-minus-circle"></i></button>
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
                                      data-bind="value: notes"></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"><h4 class="form-subtitle">Media</h4></div>
                    <div class="col-md-10">
                        TODO
                        <hr>
                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
<script>
// TODO: add pre script and post script...
    var matchData = {!! $matchJSON !!};
    var metaData = {!! $metaData !!};
    var matchViewModel = null;
</script>
@endsection

@section('page-scripts')

@endsection