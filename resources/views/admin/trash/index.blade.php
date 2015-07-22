@extends('admin.app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/opponents/trash/empty') }}" class="btn btn-danger btn-block"><i class="fa fa-times-circle"></i> Empty trash</a>
            </div>
            <div class="col-md-6">
                <a href="{{ url('admin/opponents/trash/restore') }}" class="btn btn-info btn-block"><i class="fa fa-reply-all"></i> Restore all</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-grid table-admin">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $opponent)
                            <tr>
                                <td><a href="{{ url('admin/opponents/edit', [$opponent->id]) }}">{{ $opponent->name }}</a></td>
                                <td>{{ $opponent->description }}</td>
                                <td>
                                    <a href="#" class="text-restore">Restore</a>
                                    <a href="{{ url('admin/opponents/delete', [$opponent->id]) }}" class="text-delete" data-confirm="Are you sure that you want to permanently delete this opponent?">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                        <tr>
                            <td colspan="2" class="table-info-footer">Showing {{ $rowsLimit }} of total {{ $totalItems }} results.</td>
                            <td colspan="2">{!! $data->appends(['sort' => $sortColumn, 'order' => $order, 'search' => $searchTerm])->render() !!}</td>
                        </tr>
                    </tfoot> --}}
                </table>
            </div>
        </div>
    </div>

@endsection