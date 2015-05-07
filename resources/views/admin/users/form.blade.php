@extends('app-admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Create new user</h1>
                {!! Form::open() !!}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password</label>
                        <input type="password" class="form-control" id="pwd" name="pwd" required>
                    </div>
                    <div class="form-group">
                        <label for="roles">Choose roles</label>
                        <select name="roles[]" id="roles" class="form-control" multiple>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    <button class="btn btn-success" type="submit">Save</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection