@extends('admin.app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($post, ['id' => 'post-form']) !!}
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="form-subtitle">Content</h4>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}
                            {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required', 'minlength' => '5']) !!}
                            {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary', ['class' => 'control-label']) !!}
                            {!! Form::textarea('summary', null, ['class' => 'form-control', 'rows' => '2']) !!}
                            {!! $errors->first('summary', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                            {!! Form::label('content', 'Post content', ['class' => 'control-label']) !!}
                            {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => '6', 'id' => 'post-content', 'required' => 'required']) !!}
                            {!! $errors->first('content', '<span class="help-block">:message</span>') !!}
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="form-subtitle">Meta</h4>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('publish_date_start') ? 'has-error' : '' }}">
                                    {!! Form::label('publish_date_start', 'Publish on date', ['class' => 'control-label']) !!}
                                    {!! Form::text('publish_date_start', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('publish_date_start', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('publish_date_end') ? 'has-error' : '' }}">
                                    {!! Form::label('publish_date_end', 'Publish to date', ['class' => 'control-label']) !!}
                                    {!! Form::text('publish_date_end', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('publish_date_end', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('post_category_id') ? 'has-error' : '' }}">
                            {!! Form::label('post_category_id', 'Category', ['class' => 'control-label']) !!}
                            {!! Form::select('post_category_id', $categories, $post->post_category_id, ['class' => 'form-control']) !!}
                            {!! $errors->first('post_category_id', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="radio">
                                    <label>
                                        {!! Form::radio('comments', 1, true) !!}
                                        Allow comments on post
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        {!! Form::radio('comments', 0) !!}
                                        Disable comments on post
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="radio">
                                    <label>
                                        {!! Form::radio('status', 'draft') !!}
                                        Save as draft
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        {!! Form::radio('status', 'published', true) !!}
                                        Prepare to publish
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="text-right">
                    <a href="/admin/posts" class="btn btn-default">Cancel</a>
                    <button class="btn btn-success" type="submit">Save <i class="fa fa-chevron-right"></i></button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script src="{{ asset('/js/admin/lib/simplemde.min.js') }}"></script>
    <script src="{{ asset('/js/admin/modules/posts.js') }}"></script>
@endsection