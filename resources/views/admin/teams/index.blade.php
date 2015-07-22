@extends('admin.app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/teams/new') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> New squad</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                @if(!$data)
                    <div class="alert alert-info">There are no squads created yet!</div>
                @endif
                <div class="list-group">
                    @foreach($data as $team)
                        <a href="{{ url('admin/teams/edit', [$team->id]) }}" class="list-group-item clearfix">
                            @if($team->image)
                                <img class="pic-50 pic-left" src="/uploads/teams/{{ $team->image }}" alt="Image"/>
                            @else
                                <img class="pic-50 pic-left" src="/uploads/nopic.jpg" alt="No picture"/>
                            @endif
                            <h4 class="list-group-item-heading">{{ $team->name }}</h4>
                            <p class="list-group-item-text">{{ $team->description }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection