@extends('admin.app-admin')

@section('content')
    <div class="container">
        {!! Form::model($model, ['files' => true, 'id' => 'game-form', 'class' => 'row']) !!}
        <div class="col-xs-8">
            <div class="section section-main">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-inline">
                            <label class="control-label" for="name">Name</label>
                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-inline">
                            <label class="control-label" for="code">Short code</label>
                            {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'code']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-inline">
                            <label class="control-label" for="image">Image</label>
                            @if(!empty($model->image))
                                <div class="uploaded-file">
                                    <img src="/uploads/games/{{ $model->image }}" alt="Image"/>
                                </div>
                            @endif
                            <input class="form-control" type="file" name="image" id="image">
                        </div>
                    </div>
                </div>
            </div>
            <div class="section section-main">
                <div class="row">
                    <div class="col-xs-12">
                        <button class="btn btn-sm btn-success" type="button" data-bind="click: addMap"><i class="fa fa-plus"></i> Add map</button>
                        <hr>
                        <div class="map-list clearfix" data-bind="foreach: maps">
                            <div class="map">
                                <div class="map-image">
                                    <img class="media-object" alt="Map image" data-bind="attr: {src: '/uploads/maps/' + image()}">
                                    <button class="btn btn-corner btn-overlay btn-sm" type="button" data-bind="click: removeMap"><i class="fa fa-remove"></i></button>
                                </div>
                                <div class="map-form">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-dark" placeholder="Map name here..." data-bind="value: name, attr: {name: 'mapname['+$index()+']'}">
                                    </div>
                                    <div class="form-group">
                                        <input type="file" data-bind="attr: {name: 'mapimage['+$index()+']'}">
                                        <input type="hidden" data-bind="value: id, attr: {name: 'mapid['+$index()+']'}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right">
            <a href="/admin/games" class="btn btn-default">Cancel</a>
            <button class="btn btn-success" type="submit">Save <i class="fa fa-chevron-right"></i></button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('page-scripts')
    <script>
        // TODO: rly, this is bad, but knockout doesn't play nice with passing ajax data to viewmodel
        const modelData = {!! $maps !!};
    </script>
    <script src="{{ asset('/js/admin/modules/games.js') }}"></script>
@endsection