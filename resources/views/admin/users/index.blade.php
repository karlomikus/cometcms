@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/users/new') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> New user</a>
            </div>
            <form class="col-md-6" method="get" action="{{ url('admin/users') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Enter search term...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
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
                                        <a href="{{ url('admin/roles/edit', [$role->id]) }}">{{ $role->display_name }}</a><br>
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
        {!! $users->render() !!}
    </div>
@endsection