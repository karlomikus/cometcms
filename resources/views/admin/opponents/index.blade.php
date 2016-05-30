@extends('admin.app-admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section section-main">
                    @include('admin.partials.index-action', ['module' => 'opponents'])
                    {!! $grid !!}
                </div>
            </div>
        </div>
    </div>

@endsection