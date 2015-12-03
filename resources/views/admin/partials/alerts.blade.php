@if(Session::has('alerts') || $errors->any())
    <!-- Custom alerts -->
    <div class="container" id="alerts-container">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                <h3>Validation error!</h3>
                <ul>
                    @foreach($errors->all() as $error)
                        <li><span>{{ $error }}</span></li>
                    @endforeach
                </ul>
            </div>
        @else
            @foreach(Session::get('alerts') as $alert)
                <div class="alert alert-{{ $alert['type'] }} alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    @if($alert['type'] == 'success')
                        <h3>Success!</h3>
                    @else
                        <h3>An error occured!</h3>
                    @endif
                    {{ $alert['message'] }}
                    @if($alert['exception'])
                        <hr>
                        <strong class="text-danger">Related exception message <i class="fa fa-caret-down"></i></strong><br>
                        {{ $alert['exception'] }}
                    @endif
                </div>
            @endforeach
        @endif
    </div>
@endif