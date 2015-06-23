@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="squad-form">
                {!! Form::open(['files' => true]) !!}
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
                                <ul>
                                    @if($maps)
                                        @foreach($maps as $map)
                                            <li>{{ $map->image }} - {{ $map->name }}</li>
                                        @endforeach
                                    @endif
                                    <li>
                                        <input type="text" name="mapname[0]" class="form-control" placeholder="Map name here...">
                                        <input type="file" name="mapimage[0]">
                                    </li>
                                    <li>
                                        <input type="text" name="mapname[1]" class="form-control" placeholder="Map name here...">
                                        <input type="file" name="mapimage[1]">
                                    </li>
                                    <li>
                                        <input type="text" name="mapname[2]" class="form-control" placeholder="Map name here...">
                                        <input type="file" name="mapimage[2]">
                                    </li>
                                    <li>
                                        <input type="text" name="mapname[3]" class="form-control" placeholder="Map name here...">
                                        <input type="file" name="mapimage[3]">
                                    </li>
                                </ul>
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
        const modelData = {* $modelData *};
    </script>
@endsection

@section('page-scripts')
    <script src="{{ asset('/js/admin/games.js') }}"></script>
@endsection