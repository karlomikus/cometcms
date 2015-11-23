@extends('admin.app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section section-main">
                    @include('admin.partials.index-action', ['module' => 'users'])
                    <table class="table table-hover table-grid table-admin">
                        <thead>
                            <tr>
                                <th>{!! Form::gridHeader('Name', 'name', 'Admin\UsersController@index', $headerAttr) !!}</th>
                                <th>{!! Form::gridHeader('E-mail', 'email', 'Admin\UsersController@index', $headerAttr) !!}</th>
                                <th>{!! Form::gridHeader('Registered on', 'created_at', 'Admin\UsersController@index', $headerAttr) !!}</th>
                                <th>Roles</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$totalItems > 0)
                                <tr>
                                    <td colspan="5" class="text-center">No results found.</td>
                                    <td></td>
                                </tr>
                            @endif
                            @foreach($data as $user)
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
                                        <a href="{{ url('admin/users/delete', [$user->id]) }}" class="text-delete">Trash</a>
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
    </div>
@endsection