@extends('admin.app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('admin/teams/new') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Create</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="team-group">
                    @forelse($data as $team)
                        <a href="{{ url('admin/teams/edit', [$team->id]) }}" class="team-group-item clearfix">
                            <div class="row">
                                <div class="col-md-8">
                                    @if($team->image)
                                        <img class="pic-50 pic-left" src="/uploads/teams/{{ $team->image }}" alt="Image"/>
                                    @else
                                        <img class="pic-50 pic-left" src="/uploads/nopic.jpg" alt="No picture"/>
                                    @endif
                                    <h4 class="team-group-item-heading">{{ $team->name }}</h4>
                                    <p class="team-group-item-text">{{ str_limit($team->description, 90) }}</p>
                                </div>
                                <div class="col-md-2 text-center">
                                    <h4 class="team-group-item-heading">{{ $team->roster->count() }}</h4>
                                    <p class="team-group-item-text">Members</p>
                                </div>
                                <div class="col-md-2 text-center">
                                    <h4 class="team-group-item-heading">{{ $team->matches->count() }}</h4>
                                    <p class="team-group-item-text">Matches</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="alert alert-info">
                            <h3>No data!</h3>
                            You have not created any squads yet!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection