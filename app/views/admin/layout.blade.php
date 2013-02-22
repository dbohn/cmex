<!doctype html>
<html lang="de">
<head>
    <title>cmex!-Administration</title>
    <meta charset="utf-8" />
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/css/bootstrap-combined.min.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/js/bootstrap.min.js"></script>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/jquery-ui.css" type="text/css" />
	
	<script>
	<!--
	
	var userTabsFirstLoad = false;
	function loadUser(id) {
		$('#user-info-link').attr('href', '{{ URL::to('admin/info/user') }}/' + id);
		$('#user-groups-link').attr('href', '{{ URL::to('admin/group/user') }}/' + id);
		$('#user-permissions-link').attr('href', '{{ URL::to('admin/permission/user') }}/' + id);
		
		if(!userTabsFirstLoad) {
			$('#user-tabs').tabs({
				beforeLoad: function( event, ui ) {
					ui.jqXHR.error(function() {
						ui.panel.html("Couldn't load this tab. We'll try to fix this as soon as possible.");
					});
				}
			});
			$('#user-tabs').show();
			userTabsFirstLoad = true;
		}
	}
	
	$(function() {
		
	});
	
	//-->
	</script>
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