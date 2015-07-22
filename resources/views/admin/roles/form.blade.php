@extends('admin.app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($model, ['id' => 'role-form']) !!}
                    <div class="row">
                        <div class="col-md-2">
                            <h4 class="form-subtitle">Information</h4>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group {{ $errors->has('display_name') ? 'has-error' : '' }}">
                                {!! Form::label('display_name', 'Name', ['class' => 'control-label']) !!}
                                {!! Form::text('display_name', null, ['class' => 'form-control', 'required' => 'required', 'minlength' => '3']) !!}
                                {!! $errors->first('display_name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3']) !!}
                                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <h4 class="form-subtitle">Permissions</h4>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                @if(isset($model) && $model->id == 1)
                                    <div class="alert alert-warning">
                                        <h3>Notice!</h3>
                                        You are editing a base role, choosing permissions is disabled!
                                    </div>
                                @endif
                                <button class="btn btn-sm btn-default" type="button">Check all</button>
                                <button class="btn btn-sm btn-default" type="button">Uncheck all</button>
                                <br>
                                @foreach($perms as $perm)
                                    <div class="role-info checkbox">
                                        <label>
                                            <input type="checkbox" value="{{ $perm->id }}" name="perms[]" {{ in_array($perm->id, $selectedPerms) == true ? 'checked' : '' }} {{ (isset($model) && $model->id == 1) ? 'disabled' : '' }}> {{ $perm->display_name }}
                                        </label>
                                        <p class="help-block">{{ $perm->description }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="/admin/roles" class="btn btn-default">Cancel</a>
                        <button class="btn btn-success" type="submit">Save <i class="fa fa-chevron-right"></i></button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection