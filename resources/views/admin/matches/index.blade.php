@extends('admin.app-admin')

@section('content')
    <div class="container">

        @include('admin.partials.index-action', ['module' => 'matches'])

        <div class="row">
            <div class="col-md-12">
                <table class="table table-admin table-hover table-grid">
                    <thead>
                        <tr>
                            <th>{!! Form::gridHeader('Played on', 'date', 'Admin\MatchesController@index', $headerAttr) !!}</th>
                            <th>{!! Form::gridHeader('Team', 'teams.name', 'Admin\MatchesController@index', $headerAttr) !!}</th>
                            <th>{!! Form::gridHeader('Opponent', 'opponents.name', 'Admin\MatchesController@index', $headerAttr) !!}</th>
                            <th>{!! Form::gridHeader('Game', 'games.name', 'Admin\MatchesController@index', $headerAttr) !!}</th>
                            <th>Outcome</th>
                            <th></th>
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
                                <td><a href="{{ url('admin/matches/edit', [$match->id]) }}">{{ $match->date->format('d.m.Y - H:i') }}</a></td>
                                <td>{{ $match->team->name }}</td>
                                <td>{{ $match->opponent->name }}</td>
                                <td>{{ $match->game->name }}</td>
                                <td class="match-{{ $match->outcome }}"><strong>{{ $match->outcome }}</strong></td>
                                {{-- <td><strong data-toggle="tooltip" data-placement="top" title="{{ $match->score->home }} : {{ $match->score->guest }}" class="match-{{ $match->outcome }}">{{ $match->outcome }}</strong></td> --}}
                                <td>
                                    <a href="{{ url('admin/matches/delete', [$match->id]) }}" class="text-delete" data-confirm="Are you sure you want to delete this match?">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="table-info-footer">Showing {{ $rowsLimit }} of total {{ $totalItems }} results.</td>
                            <td colspan="3">{!! $data->appends(['sort' => $sortColumn, 'order' => $order, 'search' => $searchTerm])->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script>
        $('[data-toggle="tooltip"]').tooltip();
    </script>
@endsection