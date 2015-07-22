@extends('admin.app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="game-form">
                {!! Form::model($model, ['files' => true, 'id' => 'game-form']) !!}
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="form-subtitle">Game information</h4>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Name</label>
                                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                            </div>
                            <div class="form-group col-md-6">
                                <label for="code">Short code</label>
                                {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'code']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    @if(!empty($model->image))
                                        <div class="uploaded-file">
                                            <img src="/uploads/games/{{ $model->image }}" alt="Image"/>
                                        </div>
                                    @endif
                                    <input type="file" name="image" id="image">
                                </div>
                            </div>
                        </div>
                        <hr/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"><h4 class="form-subtitle">Maps</h4></div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12">
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
                        <hr>
                    </div>
                </div>
                <div class="text-right">
                    <a href="/admin/games" class="btn btn-default">Cancel</a>
                    <button class="btn btn-success" type="submit">Save <i class="fa fa-chevron-right"></i></button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('page-scripts-before')
    <script>
        // TODO: rly, this is bad, but knockout doesn't play nice with passing ajax data to viewmodel
        const modelData = {!! $maps !!};
    </script>
@endsection

@section('page-scripts')
    <script src="{{ asset('/js/admin/games.js') }}"></script>
@endsection