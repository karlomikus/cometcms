@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/matches/new') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> New match</a>
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
                            <th>Played on</th>
                            <th>Team</th>
                            <th>Versus</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matches as $match)
                            <tr>
                                <td><a href="{{ url('admin/matches/edit', [$match->id]) }}">{{ $match->created_at }}</a></td>
                                <td>{{ $match->team }}</td>
                                <td>{{ $match->opponent }}</td>
                                <td>
                                    <a href="{{ url('admin/matches/delete', [$match->id]) }}" class="btn btn-danger btn-xs">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection