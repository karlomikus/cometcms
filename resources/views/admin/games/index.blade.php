@extends('admin.app-admin')

@section('content')
    <div class="container">

        @include('admin.partials.index-action', ['module' => 'games'])

        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-grid table-admin">
                    <thead>
                    <tr>
                        <th colspan="2">{!! Form::gridHeader('Name', 'name', 'Admin\GamesController@index', $headerAttr) !!}</th>
                        <th>Maps</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!$totalItems > 0)
                        <tr>
                            <td colspan="5" class="text-center">No results found.</td>
                        </tr>
                    @endif
                    @foreach($data as $game)
                        <tr>
                            <td style="width: 28px;"><img src="{{ url('uploads/games/' . $game->image) }}" alt="missing" style="max-width: 25px; heght: auto;"></td>
                            <td><a href="{{ url('admin/games/edit', [$game->id]) }}">{{ $game->name }}</a></td>
                            <td>{{ $game->maps->count() }}</td>
                            <td>
                                <a href="{{ url('admin/games/delete', [$game->id]) }}" class="text-delete">Trash</a>
                            </td>
                        </tr>
                    @endforeach
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