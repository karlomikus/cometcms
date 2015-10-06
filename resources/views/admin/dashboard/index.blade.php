@extends('admin.app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Manage team</div>
                    <div class="panel-body">
                        <ul class="nav nav-stacked">
                            @foreach($teams as $team)
                                <li><a href="/admin/teams/edit/{{ $team->id }}"><strong>{{ $team->name }}</strong><br><small>{{ $team->roster->count() }} Members | 23 Matches | 12 Wins</small></a></li>
                             @endforeach
                            <li><a href="/admin/teams">View more...</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Your next match</div>
                    <div class="panel-body">
                        @if ($latestMatch)
                            Versus: {{ $latestMatch['opponent'] }} <br>
                            Date: {{ $latestMatch['date'] }}
                        @endif
                    </div>
                </div>
                <a href="{{ url('admin/posts/new') }}" class="btn btn-lg btn-block btn-info">Create post</a>
                <br>
                <a href="{{ url('admin/matches/new') }}" class="btn btn-lg btn-block btn-info">Create match</a>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ date('Y') }} Match statistics</div>
                    <div class="panel-body">
                        <canvas id="matches-graph" style="width: 100%; height: 200px;"></canvas>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-4">WON: {{ $matchStats['won'] }}</div>
                            <div class="col-md-4">LOST: {{ $matchStats['lost'] }}</div>
                            <div class="col-md-4">DRAW: {{ $matchStats['draw'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script src="{{ asset('/js/admin/modules/dashboard.js') }}"></script>
@endsection