@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Team</th>
                            <th>Played on</th>
                            <th>Versus</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matches as $match)
                            <tr>
                                <td>{{ $match->id }}</td>
                                <td>{{ $match->team }}</td>
                                <td>{{ $match->created_at }}</td>
                                <td>{{ $match->opponent }}</td>
                                <td>
                                    <a href="#">Edit</a> |
                                    <a href="#">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection