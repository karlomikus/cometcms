@extends('admin.app-admin')

@section('content')
    <div class="container">

        @include('admin.partials.index-action', ['module' => 'roles'])

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
                                <td><a href="{{ url('admin/roles/edit', [$role->id]) }}">{{ $role->display_name }}</a></td>
                                <td>{{ $role->description }}</td>
                                <td>
                                    <a href="{{ url('admin/roles/delete', [$role->id]) }}" class="text-delete" data-confirm="Are you sure that you want to delete this role?">Delete</a>
                                </td>
                            </tr>
                        @endforeach
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