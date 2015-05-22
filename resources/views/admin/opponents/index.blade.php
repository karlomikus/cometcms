@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/opponents/new') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> New opponent</a>
            </div>
            <form class="col-md-6" method="get" action="{{ url('admin/opponents') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Enter search term..." value="{{ !empty($searchTerm) ? $searchTerm : "" }}" tabindex="1">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        @if(!empty($searchTerm))
                            <a class="btn btn-primary" href="{{ url('admin/opponents') }}"><i class="glyphicon glyphicon-remove"></i></a>
                        @endif
                    </span>
                </div>
            </form>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{!! Form::gridHeader('Name', 'name', 'Admin\OpponentsController@index', $headerAttr) !!}</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$totalItems > 0)
                            <tr>
                                <td colspan="5" class="text-center">No results found.</td>
                            </tr>
                        @endif
                        @foreach($data as $opponent)
                            <tr>
                                <td><a href="{{ url('admin/opponents/edit', [$opponent->id]) }}">{{ $opponent->name }}</a></td>
                                <td>{{ $opponent->description }}</td>
                                <td>
                                    <a href="{{ url('admin/opponents/delete', [$opponent->id]) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this opponent?');">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {!! $data->appends(['sort' => $sortColumn, 'order' => $order, 'search' => $searchTerm])->render() !!}
    </div>
@endsection