@extends('admin.app-admin')

@section('content')
    <div class="container">
       {!! Form::model($post, ['id' => 'post-form', 'class' => 'row']) !!}
            <div class="col-md-9">
                <div class="section section-main">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group form-group-accent form-group-inline {{ $errors->has('title') ? 'has-error' : '' }}">
                                {!! Form::label('title', 'Title', ['class' => 'control-label required']) !!}
                                {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required', 'minlength' => '5', 'placeholder' => 'Type post title...']) !!}
                                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group form-group-inline {{ $errors->has('post_category_id') ? 'has-error' : '' }}">
                                {!! Form::label('post_category_id', 'Category', ['class' => 'control-label']) !!}
                                {!! Form::select('post_category_id', $categories, $post->post_category_id, ['class' => 'form-control']) !!}
                                {!! $errors->first('post_category_id', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group form-group-inline {{ $errors->has('summary') ? 'has-error' : '' }}">
                                {!! Form::label('summary', 'Summary', ['class' => 'control-label']) !!}
                                {!! Form::textarea('summary', null, ['class' => 'form-control', 'rows' => '2', 'placeholder' => 'Type short post summary...']) !!}
                                {!! $errors->first('summary', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group form-group-inline {{ $errors->has('content') ? 'has-error' : '' }}">
                                {!! Form::label('content', 'Post content', ['class' => 'control-label required']) !!}
                                {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => '6', 'id' => 'post-content', 'required' => 'required']) !!}
                                {!! $errors->first('content', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <aside class="section section-main">
                    <div class="section-body">
                        <div class="form-group {{ $errors->has('publish_date_start') ? 'has-error' : '' }}">
                            {!! Form::label('publish_date_start', 'Publish on date', ['class' => 'control-label']) !!}
                            {!! Form::text('publish_date_start', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('publish_date_start', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('publish_date_end') ? 'has-error' : '' }}">
                            {!! Form::label('publish_date_end', 'Publish to date', ['class' => 'control-label']) !!}
                            {!! Form::text('publish_date_end', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('publish_date_end', '<span class="help-block">:message</span>') !!}
                        </div>
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
                        @if ($post->status === 'draft')
                            <button class="btn btn-block btn-action" name="save-type" value="publish" type="submit">Publish now</button>
                            <button class="btn btn-block btn-primary" name="save-type" value="draft" type="submit">Save</button>
                            <a href="/admin/posts" class="btn btn-block btn-primary">Cancel</a>
                        @else
                            <button class="btn btn-block btn-action" name="save-type" value="publish" type="submit">Save and publish</button>
                            <button class="btn btn-block btn-primary" name="save-type" value="draft" type="submit">Save as draft</button>
                            <a href="/admin/posts" class="btn btn-block btn-primary">Cancel</a>
                        @endif
                    </div>
                </aside>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('page-scripts')
    <script src="{{ asset('/js/admin/lib/simplemde.min.js') }}"></script>
    <script src="{{ asset('/js/admin/modules/posts.js') }}"></script>
@endsection