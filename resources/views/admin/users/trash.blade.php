@extends('admin.app-admin')

@section('breadcrumbs')
    <a href="{{ url('admin/users') }}" class="btn btn-dark"><i class="fa fa-caret-left"></i></a>
@endsection

@section('content')
    <div class="container">
        <div class="alert alert-warning">
            <h3>Warning!</h3>
            Permanently deleting users will also permanently delete all records where they are referenced. This will affect: groups.
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/users/trash?empty=all') }}" class="btn btn-danger"><i class="fa fa-times-circle"></i> Empty trash</a>
                <a href="{{ url('admin/users/trash?restore=all') }}" class="btn btn-info"><i class="fa fa-reply-all"></i> Restore all</a>
            </div>
            <form class="col-md-6" method="get" action="{{ url('admin/users/trash') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Enter search term..." value="{{ !empty($searchTerm) ? $searchTerm : "" }}" tabindex="1">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        @if(!empty($searchTerm))
                            <a class="btn btn-primary" href="{{ url('admin/users/trash') }}"><i class="glyphicon glyphicon-remove"></i></a>
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
                            <th>{!! Form::gridHeader('Name', 'name', 'Admin\UsersController@trash', $headerAttr) !!}</th>
                            <th>{!! Form::gridHeader('E-mail', 'email', 'Admin\UsersController@trash', $headerAttr) !!}</th>
                            <th>{!! Form::gridHeader('Registered on', 'created_at', 'Admin\UsersController@trash', $headerAttr) !!}</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $user)
                            <tr>
                                <td><a href="{{ url('admin/users/edit', [$user->id]) }}">{{ $user->name }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d.m.Y - H:i:s') }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <a href="{{ url('admin/roles/edit', [$role->id]) }}">{{ $role->display_name }}</a><br>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ url('admin/users/restore', [$user->id]) }}" class="text-restore">Restore</a>
                                    <a href="{{ url('admin/users/remove', [$user->id]) }}" class="text-delete" data-confirm="Are you sure that you want to permanently delete this user?">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="no-results">No results found.</td>
                            </tr>
                        @endforelse
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