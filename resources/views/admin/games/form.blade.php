@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="squad-form">
                {!! Form::open() !!}
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="form-subtitle">Game information</h4>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" data-bind="value: name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="shortcode">Short code</label>
                                <input type="text" id="shortcode" name="shortcode" class="form-control" data-bind="value: shortcode">
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
                                    <li>Maps #1</li>
                                    <li>Maps #2</li>
                                    <li>Maps #3</li>
                                    <li><a href="#">Add map</a></li>
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
    <script src="{{ asset('/js/admin/squad.js') }}"></script>
@endsection