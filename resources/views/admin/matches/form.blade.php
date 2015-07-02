@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="match-form" style="display: none;">
                {!! Form::open(['id' => 'match-form', 'class' => 'admin-form']) !!}
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="form-subtitle">Match information</h4>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="game">Choose game</label>
                                    <select class="form-control" id="game" name="game" style="width: 100%" data-bind="value: game_id, options: games, optionsText: 'name', optionsValue: 'id', optionsAfterRender: setGameIcons">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event">Select event</label>
                                    <select class="form-control" id="event" name="event" disabled>
                                        <option value="0" selected>Coming soon!</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="match-date">Match date:</label>
                                    <input type="text" id="match-date" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Played on date..." />
                                </div>
                            </div>
                        </div>
                        <hr/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"><h4 class="form-subtitle">Participants</h4></div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="team">Choose team</label>
                                <select class="form-control" id="team" name="team" data-bind="value: team_id, event: {change: fetchTeamMembers}, disable: searchingTeamMembers()">
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
                                <i class="fa fa-lg fa-spinner fa-pulse" data-bind="css: {hide: !searchingTeamMembers()}"></i>
                                <ul class="players-list" data-bind="foreach: home_team">
                                    <li data-bind="css: {active: active}"><a href="#" data-bind="text: name, click: toggleActiveHomeParticipant"></a></li>
                                </ul>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Add standin...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="button">Add!</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <ul class="players-list" data-bind="foreach: guest_team">
                                    <li class="active"><!--ko text: $data--><!--/ko--><a href="#" data-bind="click: $parent.removeOpponentTeamMember"><i class="fa fa-remove"></i></a></li>
                                </ul>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Type member name..." data-bind="value: guest_team_name">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="button" data-bind="click: addOpponentTeamMember">Add!</button>
                                    </span>
                                </div>
                            </div>
                        </div>
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
                                   data-bind="attr: { href: '#round' + $index() }"><!--ko text: 'Game ' + ($index() + 1)--><!--/ko--></a></li>
                        </ul>
                        <div class="tab-content rounds-content" data-bind="foreach: rounds">
                            <div class="tab-pane" data-bind="attr: { id: 'round' + $index() }, css: $index() == 0 ? 'active' : ''">
                                <div class="round-options">
                                    <button class="btn btn-sm btn-danger" data-bind="click: $parent.removeRound">Remove this game <i class="fa fa-fw fa-remove"></i></button>
                                    <button class="btn btn-sm btn-info pull-right" data-bind="click: addScore"><i
                                                class="fa fa-fw fa-plus-circle"></i> Add score
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label for="map">Map</label>
                                    <select class="form-control map-input" name="map" id="map" style="width: 100%" data-bind="value: map_id, options: maps, optionsText: 'name', optionsValue: 'id', optionsAfterRender: setMapIcons">
                                    </select>
                                </div>
                                <div class="clearfix scores" data-bind="foreach: scores">
                                    <div class="score-item">
                                        <div class="score-item-body">
                                            <div class="form-group">
                                                <label>TEAM SCORE</label>
                                                <input type="number" class="form-control form-control-dark" placeholder="Team score"
                                                       data-bind="value: home"/>
                                            </div>
                                            <div class="form-group">
                                                <label>OPPONENT SCORE</label>
                                                <input type="number" class="form-control form-control-dark"
                                                       placeholder="Opponent score"
                                                       data-bind="value: guest"/>
                                            </div>
                                        </div>
                                        <button class="btn-remove-score" data-bind="click: $parent.removeScore">Remove score</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

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
                        Coming soon!
                        <hr>
                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-success" type="submit" id="match-submit">Save</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('page-scripts-before')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        // TODO: rly, this is bad, but knockout doesn't play nice with passing ajax data to viewmodel
        const matchData = {!! $matchJSON !!};
        const metaData = {!! $metaData !!};
    </script>
@endsection

@section('page-scripts')
    <script src="{{ asset('/js/admin/matches.js') }}"></script>
@endsection