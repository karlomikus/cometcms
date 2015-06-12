{!! Form::model($opponent, ['files' => true]) !!}
    <div class="modal-header">
        <button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ $pageTitle }}</h4>
    </div>
    <div class="modal-body">
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
                    <a class="btn-image-delete" href="/admin/opponents/delete-image/{{ $opponent->id }}" data-ajax="get"><i class="fa fa-fw fa-remove"></i></a>
                    <img src="/uploads/opponents/{{ $opponent->image }}" alt="Image"/>
                </div>
            @endif
            {!! Form::file('image') !!}
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
        <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Save</button>
    </div>
{!! Form::close() !!}

<script>
    function ajaxCallbackSuccess(data) {
        if(data.success == true) {
            $(".uploaded-file").remove();
        }
        else {
            console.log(data.message);
        }
    }
</script>