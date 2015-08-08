@extends('admin.app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($user, ['files' => true]) !!}
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="form-subtitle">Information</h4>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            {!! Form::label('email', 'E-mail', ['class' => 'control-label']) !!}
                            {!! Form::text('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
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
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="form-subtitle">Access</h4>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                            {!! Form::label('roles', 'Choose roles', ['class' => 'control-label']) !!}
                            {!! Form::select('roles[]', $roles->lists('display_name', 'id'), !empty($user) ? $user->roles->lists('id')->toArray() : null, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'roles']) !!}
                            {!! $errors->first('roles', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('pwd') ? 'has-error' : '' }}">
                            <label for="pwd" class="control-label">Password <small>Leave empty for default</small></label>
                            <input type="password" class="form-control" id="pwd" name="pwd" {{ !$user ? 'required' : '' }}>
                            {!! $errors->first('pwd', '<span class="help-block">:message</span>') !!}
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="form-subtitle">Profile</h4>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                            {!! Form::label('first_name', 'First name', ['class' => 'control-label']) !!}
                            {!! Form::text('first_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                            {!! Form::label('last_name', 'Last name', ['class' => 'control-label']) !!}
                            {!! Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="text-right">
                    <a href="/admin/users" class="btn btn-default">Cancel</a>
                    <button class="btn btn-success" type="submit">Save <i class="fa fa-chevron-right"></i></button>
                </div>
                {!! Form::close() !!}
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