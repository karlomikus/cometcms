<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ $pageTitle }}</h4>

</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($opponent) !!}
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
                <hr>
                <button class="btn btn-success" type="submit">Save</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
</div>