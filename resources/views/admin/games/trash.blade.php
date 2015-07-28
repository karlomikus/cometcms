@extends('admin.app-admin')

@section('breadcrumbs')
    <a href="{{ url('admin/games') }}" class="btn btn-dark"><i class="fa fa-caret-left"></i></a>
@endsection

@section('content')
    <div class="container">
        <div class="alert alert-warning">
            <h3>Warning!</h3>
            Permanently deleting games will also permanently delete all records where they are referenced. This will affect: matches, maps and teams.
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/games/trash?empty=all') }}" class="btn btn-danger"><i class="fa fa-times-circle"></i> Empty trash</a>
                <a href="{{ url('admin/games/trash?restore=all') }}" class="btn btn-info"><i class="fa fa-reply-all"></i> Restore all</a>
            </div>
            <form class="col-md-6" method="get" action="{{ url('admin/games/trash') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Enter search term..." value="{{ !empty($searchTerm) ? $searchTerm : "" }}" tabindex="1">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        @if(!empty($searchTerm))
                            <a class="btn btn-primary" href="{{ url('admin/games/trash') }}"><i class="glyphicon glyphicon-remove"></i></a>
                        @endif
                    </span>
                </div>
            </form>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-grid table-admin">
                    <thead>
                        <tr>
                            <th colspan="2">{!! Form::gridHeader('Name', 'name', 'Admin\GamesController@trash', $headerAttr) !!}</th>
                            <th>Maps</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $game)
                            <tr>
                                <td style="width: 28px;"><img src="{{ url('uploads/games/' . $game->image) }}" alt="missing" style="max-width: 25px; heght: auto;"></td>
                                <td><a href="{{ url('admin/games/edit', [$game->id]) }}">{{ $game->name }}</a></td>
                                <td>{{ $game->maps->count() }}</td>
                                <td>
                                    <a href="{{ url('admin/games/restore', [$game->id]) }}" class="text-restore">Restore</a>
                                    <a href="{{ url('admin/games/remove', [$game->id]) }}" class="text-delete" data-confirm="Are you sure that you want to permanently delete this game?">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="no-results">No results found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="table-info-footer">Showing {{ $rowsLimit }} of total {{ $totalItems }} results.</td>
                            <td colspan="2">{!! $data->appends(['sort' => $sortColumn, 'order' => $order, 'search' => $searchTerm])->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection