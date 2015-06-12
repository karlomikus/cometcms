@extends('app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/teams/new') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> New squad</a>
            </div>
            <form class="col-md-6" method="get" action="{{ url('admin/teams') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Enter search term..." value="{{ !empty($searchTerm) ? $searchTerm : "" }}" tabindex="1">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        @if(!empty($searchTerm))
                            <a class="btn btn-primary" href="{{ url('admin/teams') }}"><i class="glyphicon glyphicon-remove"></i></a>
                        @endif
                    </span>
                </div>
            </form>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                @if(!$data)
                    <div class="alert alert-info">There are no squads defined yet!</div>
                @endif
                <div class="list-group">
                    @foreach($data as $team)
                        <a href="{{ url('admin/teams/edit', [$team->id]) }}" class="list-group-item">
                            <h4 class="list-group-item-heading">{{ $team->name }}</h4>
                            <p class="list-group-item-text">{{ $team->description }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts-before')
    <script>
        // TODO: rly, this is bad, but knockout doesn't play nice with passing ajax data to viewmodel
        const squadData = null;
    </script>
@endsection

@section('page-scripts')
    <script src="{{ asset('/js/admin/squads.js') }}"></script>
@endsection