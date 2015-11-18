@extends('admin.app-admin')

@section('content')
    <div class="container">
        {!! Form::model($opponent, ['files' => true, 'id' => 'opponent-form', 'class' => 'row']) !!}
            <div class="col-md-9">
                <div class="section section-main">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group form-group-inline {{ $errors->has('name') ? 'has-error' : '' }}">
                                {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'minlength' => '3']) !!}
                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group form-group-inline">
                                {!! Form::label('image', 'Image', ['class' => 'control-label']) !!}
                                @if(!empty($opponent->image))
                                    <div class="uploaded-file">
                                        <a class="btn btn-xs btn-corner btn-overlay" href="/admin/opponents/delete-image/{{ $opponent->id }}" data-ajax="get"><i class="fa fa-fw fa-remove"></i></a>
                                        <img src="/uploads/opponents/{{ $opponent->image }}" alt="Image"/>
                                    </div>
                                @endif
                                {!! Form::file('image', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group form-group-inline {{ $errors->has('description') ? 'has-error' : '' }}">
                                {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3']) !!}
                                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="section section-main">
                    <div class="section-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-block btn-action" type="submit">Save opponent</button>
                                <a href="/admin/opponents" class="btn btn-block btn-primary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
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