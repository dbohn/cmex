<!doctype html>
<!-- This is a basic page template for cmex,
 it requires somes basic containers to build a page -->
 <html>
 <head>
    <title>Project X  {{ $title }}</title>
    <meta charset="utf-8" />
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
    <script src="http://use.edgefonts.net/maven-pro.js"></script>
    <link rel="stylesheet" href="{{ asset("templates/default/style.css") }}" />
    {{ $head }}
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="span12 header">
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
                <p>&copy; 2012 David Bohn</p>
            </div>
        </div>
    </div>
    {{ $scripts }}
</body>
</html>