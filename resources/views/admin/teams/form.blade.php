@extends('admin.app-admin')

@section('pagebar-buttons')
    <div class="col-md-6 text-right">
        <a href="#" class="btn btn-default"><i class="fa fa-fw fa-shield"></i> Match history</a>
        <a href="#" class="btn btn-default"><i class="fa fa-fw fa-line-chart"></i> Statistics</a>
    </div>
@endsection

@section('content')
    <div class="container">
        {!! Form::open(['id' => 'squad-form', 'class' => 'row', 'files' => true, 'v-on:submit.prevent' => 'onSubmit']) !!}
            <div class="col-md-9">
                <div class="section section-main">
                    <div class="row">
                        <div class="col-md-6 col-no-padding-right">
                            <div class="form-group form-group-inline">
                                <label for="name" class="control-label">Squad name</label>
                                <input type="text" id="name" name="name" class="form-control" minlength="3" v-model="squad.name" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-no-padding-left">
                            <div class="form-group fg-connector form-group-inline">
                                <label for="game" class="control-label">Primary game</label>
                                <select class="form-control games-dropdown" id="game" name="game" v-model="squad.gameID">
                                    @foreach($games as $game)
                                        <option value="{{ $game->id }}" data-icon="{{ $game->image }}">{{ $game->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-inline">
                                <label for="description" class="control-label">Description</label>
                                <textarea name="description" id="description" rows="4" class="form-control" v-model="squad.description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-inline">
                                <label for="image" class="control-label">Image</label>
                                <input class="form-control" type="file" name="image" id="image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section section-main">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group member-search-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                    <input data-toggle="dropdown" id="search-users" class="form-control" type="text" placeholder="Start typing to find and add members..." v-model="searchTerm" @keyup="getUsers() | debounce 500">
                                    <ul class="dropdown-menu" id="found-users-list">
                                        <li v-for="user in foundUsers">
                                            <a href="#" @click.prevent="addMember(user)">
                                                @{{ user.name }} @{{ user.last_name }}<br>
                                                <small>@{{ user.email }}</small>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="squad-member" v-for="member in squad.roster">
                                <img alt="Avatar" v-bind:src="'/uploads/users/' + member.image">
                                {{--<button class="btn btn-xs btn-corner btn-overlay" @click="removeMember($index)" type="button"><i class="fa fa-remove"></i></button>--}}
                                <div class="squad-member-info">
                                    <h4>@{{ member.name }}</h4>
                                    {{--<div class="form-group">--}}
                                        {{--<input type="text" class="form-control form-control-dark" placeholder="Player position..." v-model="member.pivot.position">--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<input type="text" class="form-control form-control-dark" placeholder="Player status..." v-model="member.pivot.status">--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-md-3">
            <div class="section section-main">
                <div class="section-body">
                    <input id="team-id" type="hidden" value="{{ $team->id or null }}">
                    <button id="save-squad" class="btn btn-block btn-action" type="submit">Save squad</button>
                    <a href="/admin/teams" class="btn btn-block btn-default">Cancel</a>
                    @if($team)
                        <a href="{{ url('admin/teams/delete', ['id' => $team->id]) }}" class="btn btn-block btn-danger" data-confirm="Are you sure you want to delete this squad?">Delete squad</a>
                    @endif
                </div>
            </div>
            <div class="section section-main">
                @if($history)
                    <div class="row">
                        <div class="col-md-12">
                            @foreach($history as $historyDate => $members)
                                <h3>{{ $historyDate }}</h3>
                                <ul class="list-group">
                                    @foreach($members as $member)
                                        <li class="list-group-item">{{ $member->name }} ({{ $member->position }})</li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('page-scripts')
    <script src="{{ asset('/js/admin/lib/select2.full.min.js') }}"></script>
    <script src="{{ asset('/js/admin/modules/teams.js') }}"></script>
@endsection