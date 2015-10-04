@extends('admin.app-admin')

@section('breadcrumbs')
    <a href="{{ url('admin/posts') }}" class="btn btn-dark"><i class="fa fa-caret-left"></i></a>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/posts/trash?empty=all') }}" class="btn btn-danger"><i class="fa fa-times-circle"></i> Empty trash</a>
                <a href="{{ url('admin/posts/trash?restore=all') }}" class="btn btn-info"><i class="fa fa-reply-all"></i> Restore all</a>
            </div>
            <form class="col-md-6" method="get" action="{{ url('admin/posts/trash') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Enter search term..." value="{{ !empty($searchTerm) ? $searchTerm : "" }}" tabindex="1">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        @if(!empty($searchTerm))
                            <a class="btn btn-primary" href="{{ url('admin/posts/trash') }}"><i class="glyphicon glyphicon-remove"></i></a>
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
                        <th>{!! Form::gridHeader('Title', 'title', 'Admin\PostsController@index', $headerAttr) !!}</th>
                        <th>{!! Form::gridHeader('Created on', 'created_at', 'Admin\PostsController@index', $headerAttr) !!}</th>
                        <th>{!! Form::gridHeader('Author', 'user_id', 'Admin\PostsController@index', $headerAttr) !!}</th>
                        <th>{!! Form::gridHeader('Category', 'category', 'Admin\PostsController@index', $headerAttr) !!}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($data as $post)
                        <tr>
                            <td>@if($post->status == 'draft')<span class="label label-default">draft</span>@endif <a href="{{ url('admin/posts/edit', [$post->id]) }}">{{ $post->title }}</a></td>
                            <td>{{ $post->created_at->format('d.m.Y H:i') }}</td>
                            <td>{{ $post->author->name }}</td>
                            <td>{{ $post->category->name or 'n/a' }}</td>
                            <td>
                                <a href="{{ url('admin/posts/restore', [$post->id]) }}" class="text-restore">Restore</a>
                                <a href="{{ url('admin/posts/remove', [$post->id]) }}" class="text-delete" data-confirm="Are you sure that you want to permanently delete this post?">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="no-results">No results found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3" class="table-info-footer">Showing {{ $rowsLimit }} of total {{ $totalItems }} results.</td>
                        <td colspan="2">{!! $data->appends(['sort' => $sortColumn, 'order' => $order, 'search' => $searchTerm])->render() !!}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection