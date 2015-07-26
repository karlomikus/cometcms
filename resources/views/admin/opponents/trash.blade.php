@extends('admin.app-admin')

@section('content')
    <div class="container">
        <div class="alert alert-warning">
            <h3>Warning!</h3>
            Permanently deleting opponents will also permanently delete all records where they are referenced. This includes: matches.
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/opponents/trash/empty') }}" class="btn btn-danger"><i class="fa fa-times-circle"></i> Empty trash</a>
                <a href="{{ url('admin/opponents/trash/restore') }}" class="btn btn-info"><i class="fa fa-reply-all"></i> Restore all</a>
            </div>
            <form class="col-md-6" method="get" action="{{ url('admin/opponents/trash') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Enter search term..." value="{{ !empty($searchTerm) ? $searchTerm : "" }}" tabindex="1">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        @if(!empty($searchTerm))
                            <a class="btn btn-primary" href="{{ url('admin/opponents/trash') }}"><i class="glyphicon glyphicon-remove"></i></a>
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
                            <th>{!! Form::gridHeader('Name', 'name', 'Admin\OpponentsController@trash', $headerAttr) !!}</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $opponent)
                            <tr>
                                <td><a href="{{ url('admin/opponents/edit', [$opponent->id]) }}">{{ $opponent->name }}</a></td>
                                <td>{{ $opponent->description }}</td>
                                <td>
                                    <a href="{{ url('admin/opponents/restore', [$opponent->id]) }}" class="text-restore">Restore</a>
                                    <a href="{{ url('admin/opponents/remove', [$opponent->id]) }}" class="text-delete" data-confirm="Are you sure that you want to permanently delete this opponent?">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No results found.</td>
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