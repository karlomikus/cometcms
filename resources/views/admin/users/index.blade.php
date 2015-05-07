@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/users/new') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> New user</a>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter search term...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><a href="{{ url('admin/users/edit', [$user->id]) }}">{{ $user->name }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        {{ $role->display_name }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ url('admin/user/delete', [$user->id]) }}" class="btn btn-danger btn-xs">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection