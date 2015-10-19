<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CometCMS App</title>
    
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300|Montserrat' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('css/admin/main.css') }}">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-admin">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-nav">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/admin') }}"><i class="fa fa-circle-o-notch"></i></a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-collapse-nav">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ url('/admin') }}">Dashboard</a>
                </li>
                <li>
                    <a href="{{ url('/admin/teams') }}">Squad management</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Content <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/admin/posts') }}">Posts</a></li>
                        <li class="disabled"><a href="{{ url('/admin/pages') }}">Pages</a></li>
                        <li class="disabled"><a href="{{ url('/admin/media') }}">Media library</a></li>
                        <li><a href="{{ url('/admin/games') }}">Games</a></li>
                        <li><a href="{{ url('/admin/opponents') }}">Opponents</a></li>
                        <li><a href="{{ url('/admin/matches') }}">Matches</a></li>
                        <li class="disabled"><a href="{{ url('/admin/events') }}">Events</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Site <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="disabled"><a href="{{ url('/admin/settings') }}">Settings</a></li>
                        <li class="disabled"><a href="{{ url('/admin/navigation') }}">Navigation</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users management <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/admin/users') }}">Users</a></li>
                        <li><a href="{{ url('/admin/roles') }}">User roles</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                {{-- <li><a href="#"><i class="fa fa-fw fa-bell"></i> <span class="badge">42</span></a></li> --}}
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->profile->first_name }} {{ Auth::user()->profile->last_name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/') }}">Edit profile</a></li>
                        <li><a href="{{ url('/') }}">View site</a></li>
                        <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

@include('admin.partials.pagebar')

@include('admin.partials.alerts')

@yield('content')

<footer class="site-footer">
    <div class="container">
        <div class="site-footer-content">
            <div class="row">
                <div class="col-md-6">
                    Copyright &copy; {{ date('Y') }} - Clan Comet CMS
                </div>
                <div class="col-md-6 text-right">
                    <a href="http://karlomikus.com">Support</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="{{ asset('js/admin/dependencies.js') }}"></script>
@yield('page-scripts-before')
<script src="{{ asset('js/admin/main.js') }}"></script>
@yield('page-scripts')
</body>
</html>
