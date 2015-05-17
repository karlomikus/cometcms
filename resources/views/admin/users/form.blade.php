@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                {!! Form::model($user) !!}
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
                        {!! Form::label('pwd', 'Password', ['class' => 'control-label']) !!}
                        {!! Form::password('pwd', ['class' => 'form-control']) !!}
                        {!! $errors->first('pwd', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                        {!! Form::label('roles', 'Choose roles', ['class' => 'control-label']) !!}
                        {!! Form::select('roles[]', $roles->lists('display_name', 'id'), !empty($user) ? $user->roles->lists('id') : null, ['class' => 'form-control', 'multiple' => 'multiple']) !!}
                        {!! $errors->first('roles', '<span class="help-block">:message</span>') !!}
                    </div>
                    <hr>
                    <button class="btn btn-success" type="submit">Save</button>
                {!! Form::close() !!}
            </div>
            <div class="col-md-5">
                <div class="block">
                    <h3>
                        Text block help
                        <small>Subtitle of text block</small>
                    </h3>
                    <div class="block-body">
                        Note that views which extend a Blade layout simply override sections from the layout. Content of the layout can be included in a child view using the directive in a section, allowing you to append to the contents of a layout section such as a sidebar or footer.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection