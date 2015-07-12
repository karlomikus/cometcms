@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/roles/new') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> New role</a>
            </div>
            <form class="col-md-6" method="get" action="{{ url('admin/roles') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Enter search term..." value="{{ !empty($searchTerm) ? $searchTerm : "" }}" tabindex="1">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        @if(!empty($searchTerm))
                            <a class="btn btn-primary" href="{{ url('admin/roles') }}"><i class="glyphicon glyphicon-remove"></i></a>
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
                            <th>{!! Form::gridHeader('Name', 'display_name', 'Admin\RolesController@index', $headerAttr) !!}</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$totalItems > 0)
                            <tr>
                                <td colspan="5" class="text-center">No results found.</td>
                            </tr>
                        @endif
                        @foreach($data as $role)
                            <tr>
                                <td><a href="{{ url('admin/roles/edit', [$role->id]) }}">{{ $role->name }}</a></td>
                                <td>{{ $role->description }}</td>
                                <td>
                                    <a href="{{ url('admin/roles/delete', [$role->id]) }}" class="text-delete" data-confirm="Are you sure that you want to delete this role?">Delete</a>
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