@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="game-form">
                {!! Form::open(['files' => true, 'id' => 'game-form']) !!}
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="form-subtitle">Game information</h4>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="shortcode">Short code</label>
                                <input type="text" id="shortcode" name="shortcode" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="image">Image</label>
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
                            <button class="btn btn-success" type="button" data-bind="click: addMap"><i class="fa fa-plus"></i> Add map</button>
                                <ul>
                                    @if($maps)
                                        @foreach($maps as $map)
                                            <li><img src="/uploads/maps/{{ $map->image }}" alt="Test"/> - {{ $map->name }}</li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="map-list" data-bind="foreach: maps">
                                    <div class="media">
                                      <div class="media-left">
                                        <a href="#">
                                          <img class="media-object" src="http://placehold.it/50x50" alt="Map image">
                                        </a>
                                      </div>
                                      <div class="media-body">
                                        <h4 class="media-heading"><input type="text" class="form-control" placeholder="Map name here..." data-bind="value: name, attr: {name: 'mapname['+$index()+']'}"> <button class="btn btn-danger" type="button" data-bind="click: removeMap"><i class="fa fa-remove"></i></button></h4>
                                        <input type="file" data-bind="attr: {name: 'mapimage['+$index()+']'}">
                                      </div>
                                    </div>
                                </div>
                            </div>
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

@section('page-scripts-before')
    <script>
        // TODO: rly, this is bad, but knockout doesn't play nice with passing ajax data to viewmodel
        const modelData = null;
    </script>
@endsection

@section('page-scripts')
    <script src="{{ asset('/js/admin/games.js') }}"></script>
@endsection