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
                        <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary', ['class' => 'control-label']) !!}
                            {!! Form::textarea('summary', null, ['class' => 'form-control', 'rows' => '2']) !!}
                            {!! $errors->first('summary', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                            {!! Form::label('content', 'Post body', ['class' => 'control-label']) !!}
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
                                    <input type="text" name="publish_date_start" value="{{ $post->publish_date_start }}" id="publish_date_start" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-rule-dateISO="true" required />
                                    {!! $errors->first('publish_date_start', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('publish_date_end') ? 'has-error' : '' }}">
                                    {!! Form::label('publish_date_end', 'Publish to date', ['class' => 'control-label']) !!}
                                    <input type="text" name="publish_date_end" value="{{ $post->publish_date_end }}" id="publish_date_end" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-rule-dateISO="true" required />
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
                                        {!! Form::radio('comments', 1) !!}
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
                                        {!! Form::radio('status', 'published') !!}
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
    <link rel="stylesheet" href="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        var simplemde = new SimpleMDE({ element: $("#post-content")[0] });
    </script>
@endsection