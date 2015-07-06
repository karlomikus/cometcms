@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                {!! Form::model($user, ['files' => true]) !!}
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email', 'E-mail', ['class' => 'control-label']) !!}
                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('pwd') ? 'has-error' : '' }}">
                        <label for="pwd" class="control-label">Password <small>Leave empty for default</small></label>
                        {!! Form::password('pwd', ['class' => 'form-control', 'id' => 'pwd']) !!}
                        {!! $errors->first('pwd', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                        {!! Form::label('roles', 'Choose roles', ['class' => 'control-label']) !!}
                        {!! Form::select('roles[]', $roles->lists('display_name', 'id'), !empty($user) ? $user->roles->lists('id')->toArray() : null, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'roles']) !!}
                        {!! $errors->first('roles', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('image', 'Image', ['class' => 'control-label']) !!}
                        @if(!empty($user->image))
                            <div class="uploaded-file">
                                <a class="btn-image-delete" href="/admin/users/delete-image/{{ $user->id }}" data-ajax="get"><i class="fa fa-fw fa-remove"></i></a>
                                <img src="/uploads/users/{{ $user->image }}" alt="Image"/>
                            </div>
                        @endif
                        {!! Form::file('image') !!}
                    </div>
                    <hr>
                    <button class="btn btn-success" type="submit">Save</button>
                {!! Form::close() !!}
            </div>
            <div class="col-md-4">
                <div class="block">
                    <h3>
                        Users info block
                        <small>Lorem ipsum</small>
                    </h3>
                    <div class="block-body">
                        Note that views which extend a Blade layout simply override sections from the layout. Content of the layout can be included in a child view using the directive in a section, allowing you to append to the contents of a layout section such as a sidebar or footer.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts-before')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
@endsection

@section('page-scripts')
    <script>
        $("#roles").select2();
    </script>
@endsection