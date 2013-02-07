<!doctype html>
<html>
    <head>
        <title>cmex! &mdash; Login</title>
        <meta charset="utf-8" />
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
        <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 20px;
        margin: 0 auto 5px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    </head>
    <body>
            <div class="container">

      <form action="{{ URL::to('doLogin') }}" class="form-signin" method="post">
        <h2 class="form-signin-heading">Bitte anmelden!</h2>
        @if (Session::has('error'))
        <div class="alert alert-error">{{ Session::get('error') }}</div>
        @elseif (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <input type="text" name="name" class="input-block-level" placeholder="Benutzername">
        <input type="password" name="password" class="input-block-level" placeholder="Passwort">
        <label class="checkbox">
          <input type="checkbox" name="remember-me" value="remember-me"> Angemeldet bleiben
        </label>
        <button class="btn btn-large btn-primary" type="submit">Login</button>
        <p style="display: block; margin-top: 10px"><a href="{{path()}}">&larr; Zurück zur Startseite</a></p>
      </form>
    </div>
    </body>
</html>