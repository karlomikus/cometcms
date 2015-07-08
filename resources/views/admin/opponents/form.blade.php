@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($opponent, ['files' => true, 'id' => 'opponent-form']) !!}
                    <div class="row">
                        <div class="col-md-2">
                            <h4 class="form-subtitle">Information</h4>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3']) !!}
                                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('image', 'Image', ['class' => 'control-label']) !!}
                                @if(!empty($opponent->image))
                                    <div class="uploaded-file">
                                        <a class="btn btn-xs btn-corner btn-overlay" href="/admin/opponents/delete-image/{{ $opponent->id }}" data-ajax="get"><i class="fa fa-fw fa-remove"></i></a>
                                        <img src="/uploads/opponents/{{ $opponent->image }}" alt="Image"/>
                                    </div>
                                @endif
                                {!! Form::file('image') !!}
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