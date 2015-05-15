@extends('app-admin')

@section('content')
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/matches/new') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> New match</a>
            </div>
            <form class="col-md-6" method="get" action="{{ url('admin/matches') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Enter search term..." value="{{ !empty($searchTerm) ? $searchTerm : "" }}" tabindex="1">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        @if(!empty($searchTerm))
                            <a class="btn btn-primary" href="{{ url('admin/matches') }}"><i class="glyphicon glyphicon-remove"></i></a>
                        @endif
                    </span>
                </div>
            </form>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{!! Form::gridHeader('Played on', 'created_at', 'Admin\MatchesController@index', $headerAttr) !!}</th>
                            <th>{!! Form::gridHeader('Team', 'teams.name', 'Admin\MatchesController@index', $headerAttr) !!}</th>
                            <th>{!! Form::gridHeader('Opponent', 'opponents.name', 'Admin\MatchesController@index', $headerAttr) !!}</th>
                            <th>{!! Form::gridHeader('Game', 'games.name', 'Admin\MatchesController@index', $headerAttr) !!}</th>
                            <th>Outcome</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$totalItems > 0)
                            <tr>
                                <td colspan="6" class="text-center">No results found.</td>
                            </tr>
                        @endif
                        @foreach($data as $match)
                            <tr>
                                <td><a href="{{ url('admin/matches/edit', [$match->id]) }}">{{ $match->created_at->format('d.m.Y H:i:s') }}</a></td>
                                <td>{{ $match->team->name }}</td>
                                <td>{{ $match->opponent->name }}</td>
                                <td>{{ $match->game->name }}</td>
                                <td><strong data-toggle="tooltip" data-placement="top" title="{{ $match->score->home }} : {{ $match->score->guest }}">{{ $match->outcome }}</strong></td>
                                <td>
                                    <a href="{{ url('match', [$match->id]) }}" class="btn btn-default btn-xs" target="_blank">View</a>
                                    <a href="{{ url('admin/matches/delete', [$match->id]) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this match?');">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {!! $data->appends(['sort' => $sortColumn, 'order' => $order, 'search' => $searchTerm])->render() !!}
    </div>
@endsection

@section('page-scripts')
    <script>
        $('[data-toggle="tooltip"]').tooltip();
    </script>
@endsection