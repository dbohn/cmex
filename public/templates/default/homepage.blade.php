<!doctype html>
<html lang="de">
<head>
	<title>Willkommen!</title>
	<meta charset="utf-8" />
	<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
	{{ Asset::add("jquery", "http://code.jquery.com/jquery.min.js") }}
	{{ $scripts }}
	{{ $head }}
	<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
	<script src="http://use.edgefonts.net/maven-pro.js"></script>
	<link rel="stylesheet" href="{{ asset("templates/default/style.css") }}" />

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="span12">
				<div class="hero-unit">
					<h1>cmex! ~ Project X</h1>
					<p>Das CMS der nächsten Generation. Ultra flexibel, ultra einfach, ultra schnell.</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="span3 homemenu">{{ chunk("vertmenu", "menu", "global", $page) }}</div>
			<div class="span3">
				<h4>Download</h4>
				<p>Laden Sie die neueste Version herunter!</p>
			</div>
			<div class="span3"><h4>Social Networks</h4><p>Besuchen Sie uns:</p></div>
			<div class="span3">
				<h4>Das ist...</h4>
				<p>... ein Page Template, extra für die Home-Page in cmex!</p>
			</div>
		</div>
	</div>
</body>
</html>