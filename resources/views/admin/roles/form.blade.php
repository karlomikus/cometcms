@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($model, ['id' => 'opponent-form']) !!}
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
                                {!! Form::label('perms', 'Choose', ['class' => 'control-label']) !!}
                                <select class="form-control" name="perms" id="perms" multiple>
                                    @foreach($perms as $perm)
                                        <option value="{{ $perm->id }}">{{ $perm->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                        </div>
                    </div>
                     <div class="text-right">
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script>
    function ajaxCallbackSuccess(data) {
        if(data.success == true) {
            $(".uploaded-file").remove();
        }
        else {
            alert(data.message);
        }
    }
</script>
@endsection