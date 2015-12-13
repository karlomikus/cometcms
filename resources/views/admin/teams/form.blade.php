@extends('admin.app-admin')

@section('pagebar-buttons')
    <div class="col-xs-6 text-right">
        <a href="#" class="btn btn-default"><i class="fa fa-fw fa-shield"></i> Match history</a>
        <a href="#" class="btn btn-default"><i class="fa fa-fw fa-line-chart"></i> Statistics</a>
    </div>
@endsection

@section('content')
    <div class="container">
        <div id="alerts-container"></div>
        {!! Form::open(['id' => 'squad-form', 'class' => 'row', 'files' => true, 'v-on:submit.prevent' => 'onSubmit']) !!}
            <div class="col-md-9">
                <div class="section section-main">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-inline">
                                <label for="name" class="control-label">Squad name</label>
                                <input type="text" id="name" name="name" class="form-control" minlength="3" v-model="squad.name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group fg-connector form-group-inline">
                                <label for="game" class="control-label">Primary game</label>
                                <select class="form-control" id="game" name="game"></select>
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
                                    <input data-toggle="dropdown" autocomplete="off" id="search-users" class="form-control" type="text" placeholder="Start typing to find and add members..." v-model="searchTerm" @keyup="getUsers() | debounce 500">
                                    <ul class="dropdown-menu" id="found-users-list">
                                        <li v-for="user in foundUsers">
                                            <a href="#" @click.prevent="addMember(user)">
                                                @{{ user.firstName }} @{{ user.lastName }}<br>
                                                <small>@{{ user.email }}</small>
                                            </a>
                                        </li>
                                        <li v-if="foundUsers.length < 1" class="disabled"><a href="#">No users found!</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <section class="squad-members">
                                <div class="squad-member" v-for="member in squad.roster">
                                    <div class="squad-member-header">
                                        <a href="#" data-toggle="dropdown"><i class="fa fa-lg fa-fw fa-bars"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" @click.prevent="makeCaptain($index)">Make captain</a></li>
                                            <li><a href="#" @click.prevent="removeMember($index)">Remove from roster</a></li>
                                        </ul>
                                        <i class="captain pull-right fa fa-fw fa-star" title="Current squad captain" v-if="member.captain"></i>
                                    </div>
                                    <img alt="Avatar" :src="'/uploads/users/' + member.image">
                                    <div class="squad-member-info">
                                        <h4>@{{ member.firstName }} @{{ member.lastName }}</h4>
                                        <div class="form-group">
                                            <input title="Status" placeholder="Member status..." type="text" class="form-control" v-model="member.status">
                                        </div>
                                        <div class="form-group">
                                            <input title="Position" placeholder="Member position..." type="text" class="form-control" v-model="member.position">
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-md-3">
            <div class="section section-main">
                <div class="section-body" style="position: relative;">
                    <div class="section-loader" v-if="isSubmitting">
                        <div class="loader-inner line-scale-pulse-out">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <input id="team-id" type="hidden" value="{{ $team->id or null }}">
                    <button id="save-squad" class="btn btn-block btn-action" type="submit" :disabled="isSubmitting">Save squad</button>
                    <a href="/admin/teams" class="btn btn-block btn-primary">Cancel</a>
                    @if($team)
                        <a href="{{ url('admin/teams/delete', ['id' => $team->id]) }}" class="btn btn-block btn-danger" data-confirm="Are you sure you want to delete this squad?">Delete squad</a>
                    @endif
                </div>
            </div>
            <div class="section section-main">
                <div class="row" v-if="history">
                    <div class="col-md-12">
                        <div class="squad-history-item" v-for="(date, roster) in history">
                            <h3 data-toggle="collapse" data-target="#history-id-@{{ $index }}">@{{ date | moment 'DD.MM.YYYY' }}</h3>
                            <div class="collapse" id="history-id-@{{ $index }}">
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="member in roster">@{{ member.firstName }} @{{ member.lastName }} (@{{ member.position }})</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('page-scripts')
    <script src="{{ asset('/js/admin/lib/select2.full.min.js') }}"></script>
    <script src="{{ asset('/js/admin/modules/teams.js') }}"></script>
@endsection