<!doctype html>
<html lang="de">
<head>
	<title>Willkommen!</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="{{ asset("templates/default/css/bootstrap.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("templates/default/css/bootstrap-responsive.min.css") }}" />
	{{ $scripts }}
	{{ $head }}
	<script src="http://use.edgefonts.net/lobster-two.js"></script>
	<script src="http://use.edgefonts.net/open-sans.js"></script>
	<link rel="stylesheet" href="{{ asset("templates/default/css/style.css") }}" />

</head>
<body>
	<div class="top">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="search pull-right">
                        {{ chunk("sidesearch", "search_SmallSearchForm", "global") }}
                    </div>
                    <h1>cmex!</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="center">
    	<div class="hero-unit">
			<h1>Probieren Sie es aus!</h1>
			<p>Das CMS für jedermann. Schnell, einfach, flexibel. Doch vor allem eins: kostenlos.</p>
		</div>
		<div class="container">
			<div class="row">
				<div class="span12">
					
				</div>
			</div>

			<div class="row">
				<div class="span3 sidebar">{{ chunk("vertmenu", "menu", "global", $page) }}</div>
				<div class="span3">
					{{ chunk("content", "container", $page) }}
				</div>
				<div class="span3"><h4>Social Networks</h4><p>Besuchen Sie uns:</p></div>
				<div class="span3">
					<h4>Das ist...</h4>
					<p>... ein Page Template, extra für die Home-Page in cmex!</p>
				</div>
			</div>
			<div class="row">
	            <div class="footer span12">
	                <p class="muted">&copy; 2012 - {{ date("Y") }} cmex! - Team</p>
	            </div>
	        </div>
		</div>
	</div>
</body>
</html>