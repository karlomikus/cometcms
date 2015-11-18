@extends('admin.app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section section-main">
                    @include('admin.partials.index-action', ['module' => 'opponents'])
                    <table class="table table-hover table-grid table-admin">
                    <thead>
                        <tr>
                            <th>{!! Form::gridHeader('Name', 'name', 'Admin\OpponentsController@index', $headerAttr) !!}</th>
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
                        @foreach($data as $opponent)
                            <tr>
                                <td><a href="{{ url('admin/opponents/edit', [$opponent->id]) }}">{{ $opponent->name }}</a></td>
                                <td>{{ $opponent->description }}</td>
                                <td>
                                    <a href="{{ url('admin/opponents/delete', [$opponent->id]) }}" class="text-delete">Trash</a>
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
    </div>

@endsection