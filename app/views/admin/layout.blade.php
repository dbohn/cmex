<!doctype html>
<html lang="de">
<head>
    <title>cmex!-Administration</title>
    <meta charset="utf-8" />
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/css/bootstrap-combined.min.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="navbar">
    <div class="navbar-inner navbar-static-top">
        <a class="brand" href="{{ URL::to('admin/dashboard') }}">cmex!</a>
        <ul class="nav">
            <li><a href="{{ URL::to('admin/dashboard') }}">Dashboard</a></li>
            <li><a href="{{ URL::to('admin/user') }}">Users</a></li>
            <li><a href="#">Chunks</a></li>
            <li><a href="#">Media</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
        <p class="navbar-text pull-right">Hallo {{ Authentication::getUser()->email }}! <a href="{{ URL::to('logout') }}">Abmelden</a></p>
    </div>
</div>
<div class="container">
    <div class="row">
        
        <div class="span9">
            @yield('content')
        </div>
        <div class="span3">
            @section('sidebar')
                <h2>Options</h2>
            @show
        </div>
    </div>
</div>
</body>
</html>