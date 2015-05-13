@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    @if(!empty($opponent))
                        <h2>Editing opponent: {{ $opponent->name }}</h2>
                    @else
                        <h2>Create new opponent</h2>
                    @endif
                </div>
                {!! Form::model($opponent) !!}
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                    </div>
                    <hr>
                    <button class="btn btn-success" type="submit">Save</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection