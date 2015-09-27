@extends('admin.app-admin')

@section('content')
    <div class="container">

        @include('admin.partials.index-action', ['module' => 'posts'])

        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-grid table-admin">
                    <thead>
                    <tr>
                        <th>{!! Form::gridHeader('Title', 'title', 'Admin\PostsController@index', $headerAttr) !!}</th>
                        <th>Summary</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!$totalItems > 0)
                        <tr>
                            <td colspan="5" class="text-center">No results found.</td>
                        </tr>
                    @endif
                    @foreach($data as $post)
                        <tr>
                            <td>@if($post->status == 'draft')<span class="label label-default">draft</span>@endif <a href="{{ url('admin/posts/edit', [$post->id]) }}">{{ $post->title }}</a></td>
                            <td>{{ str_limit($post->summary, 50, '...') }}</td>
                            <td>
                                <a href="{{ url('admin/posts/delete', [$post->id]) }}" class="text-delete">Trash</a>
                                <a href="{{ url('post', [$post->slug]) }}" target="_blank" class="text-restore">View</a>
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