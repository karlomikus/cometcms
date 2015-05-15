<!DOCTYPE html>
<html lang="en" ng-app="cometapp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CometCMS App</title>

    {{--<link href="{{ asset('/css/app.css') }}" rel="stylesheet">--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/admin') }}">Administration</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Content <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/admin/posts') }}">Posts</a></li>
                        <li><a href="{{ url('/admin/opponents') }}">Opponents</a></li>
                        <li><a href="{{ url('/admin/games') }}">Games</a></li>
                        <li><a href="{{ url('/admin/maps') }}">Maps</a></li>
                        <li><a href="{{ url('/admin/events') }}">Events</a></li>
                        <li><a href="{{ url('/admin/matches') }}">Matches</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Team management <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/admin/teams') }}">Teams</a></li>
                        <li><a href="{{ url('/admin/roster') }}">Roster</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Site <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/admin/settings') }}">Settings</a></li>
                        <li><a href="{{ url('/admin/navigation') }}">Navigation</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users management <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/admin/users') }}">Users</a></li>
                        <li><a href="{{ url('/admin/roles') }}">Roles</a></li>
                        <li><a href="{{ url('/admin/permissions') }}">Permissions</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/') }}">View site</a></li>
                        <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="{{ asset('/js/dependencies.js') }}"></script>
<script src="{{ asset('/js/main.js') }}"></script>
@yield('page-scripts')
</body>
</html>
