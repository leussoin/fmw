<!doctype html>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>FMW - Login</title>
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>


<script src="{{ URL::asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="container">

    <div class=".col-xs-6 .col-sm-4 centered">

        <form method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="Login">Login</label>
                <input type="text" class="form-control" name="login" id="login" aria-describedby="Login" placeholder="Entrez votre login">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Entre votre mot de passe">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</div>
</body>
</html>

