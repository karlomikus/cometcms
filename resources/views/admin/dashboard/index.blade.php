@extends('admin.app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Matches</div>
                    <div class="panel-body">
                        Something
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Your next match</div>
                    <div class="panel-body">
                        Event, date, time, info
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ date('Y') }} Match statistics</div>
                    <div class="panel-strip row">
                        <div class="col-md-4">WON: {{ $matchStats['won'] }}</div>
                        <div class="col-md-4">LOST: {{ $matchStats['lost'] }}</div>
                        <div class="col-md-4">DRAW: {{ $matchStats['draw'] }}</div>
                    </div>
                    <div class="panel-body">
                        <canvas id="matches-graph" style="width: 100%; height: 200px;"></canvas>
                    </div>
                    <div class="panel-footer">
                        Todo...
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script src="{{ asset('/js/admin/modules/dashboard.js') }}"></script>
@endsection