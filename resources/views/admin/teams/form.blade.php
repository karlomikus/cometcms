@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="squad-form">
                {!! Form::open() !!}
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="form-subtitle">Squad information</h4>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Squad name</label>
                                <input type="text" id="name" name="name" class="form-control" data-bind="value: name">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="game">Choose game</label>
                                    <select class="form-control" id="game" name="game" data-bind="value: game_id">
                                        @foreach($games as $game)
                                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" rows="4" class="form-control" data-bind="value: description"></textarea>
                                </div>
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
                    <div class="col-md-2"><h4 class="form-subtitle">Members</h4></div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12">
                                <ul data-bind="foreach: members">
                                    <li>
                                        <h3 data-bind="text: name"></h3>
                                        <ul>
                                            <li data-bind="text: position"></li>
                                            <li data-bind="text: status"></li>
                                            <li data-bind="text: captain"></li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="add-member">
                                    <input type="text" placeholder="Search users..." data-bind="value: search_string"> <button class="btn btn-primary" data-bind="click: findUsers">find!</button>
                                    <ul data-bind="foreach: found_users">
                                        <a href="#" data-bind="text: name, click: addToMembers($data)"></a>
                                    </ul>
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
        const modelData = {!! $modelData !!};
    </script>
@endsection

@section('page-scripts')
    <script src="{{ asset('/js/admin/squad.js') }}"></script>
@endsection