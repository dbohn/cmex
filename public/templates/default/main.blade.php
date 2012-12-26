<!doctype html>
<!-- This is a basic page template for cmex,
 it requires somes basic containers to build a page -->
 <html>
 <head>
    <title>Project X - {{ $title }}</title>
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
            <div class="span12 header">
                <div class="search pull-right">
                    {{ chunk("sidesearch", "search_SmallSearchForm", "global") }}
                </div>
                <h1>cmex! ~ Project X</h1>
                <h2>{{ $title }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="span3 sidebar">
                {{ chunk("vertmenu", "menu", "global", $page) }}

            </div>
            <div class="span9">
                {{ chunk("content", "container", $page) }}
            </div>
        </div>
        <div class="row">
            <div class="footer span12">
                <p class="muted">&copy; 2012 David Bohn</p>
            </div>
        </div>
    </div>
</body>
</html>