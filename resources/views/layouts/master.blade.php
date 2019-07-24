<?php App\Misc::isAuth(); ?>

        <!doctype html>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>FMW - {{ ucfirst($title) }}</title>
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- Modale -->
<!-- Modale -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


<!-- Datatables librairies -->
<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>

<!-- scripts pour bouton togle options ON / OFF -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript" src="{{ URL::asset("js/global.js") }}"></script>
<script type="text/javascript" src="{{ URL::asset("js/$title.js") }}"></script>
<link rel="stylesheet" href="{{ URL::asset("css/global.css") }}"/>
<link rel="stylesheet" href="{{ URL::asset("css/$title.css") }}"/>

<script src="{{ URL::asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
      integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>


<div class="container">

    <?php
    App\Misc::isAuth();
    ?>


    <div class=".col-xs-6 .col-sm-4 centered">

        <!-- menu de navigation -->
        <div class="nav-container">
            <ul class="nav-ul">
                <li class="nav-list">
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "menu")) {
                        echo "class = 'visit'";
                    } ?> href='/menu'>Menu</a>
                </li>

                <li class="nav-list">
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "liste-course")) {
                        echo "class = 'visit'";
                    } ?> href='/liste-course'>Liste de course</a>
                </li>

                <li class="nav-list">
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "produit")) {
                        echo "class = 'visit'";
                    } ?> href='/produit/lister'>Produit</a>
                </li>

                <li class="nav-list">
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "recette")) {
                        echo "class = 'visit'";
                    } ?> href='/recette/lister'>Recette</a>
                </li>

                <li class="nav-list">
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "parametres")) {
                        echo "class = 'visit'";
                    } ?> href='/parametres'>Paramètres</a>
                </li>

                <li class="nav-list">
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "restes")) {
                        echo "class = 'visit'";
                    } ?> href='/restes'>Restes</a>
                </li>

                <?php $oUser = session('oUser'); ?>
                <li><span id="user-name">Bienvenue {{$oUser->name}}</span></li>

            </ul>

            <ul class="nav-ul">

                <!-- menu des produits -->
                <?php if (strpos($_SERVER['REQUEST_URI'], "produit")) { ?>

                <li class="nav-list">
                    <!-- lister produits -->
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "produit/lister")) {
                        echo "class = 'visit'";
                    } ?> href='/produit/lister'>Lister les produits</a>
                </li>

                <li class="nav-list">
                    <!-- ajouter produits -->
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "ajouter")) {
                        echo "class = 'visit'";
                    } ?> href='/produit/ajouter'>Ajouter un produit</a>
                </li>

                <!-- modifier produits -->
                <?php if (strpos($_SERVER['REQUEST_URI'], "modifier")) { ?>
                <li><a class='visit' href=''>Modifier un produit</a></li>
                <?php }
                } ?>

            <!-- menu des recettes -->
                <?php if (strpos($_SERVER['REQUEST_URI'], "recette")) { ?>

                <li class="nav-list">
                    <!-- lister recette -->
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "lister")) {
                        echo "class = 'visit'";
                    } ?> href='/recette/lister'>Lister les recettes</a>
                </li>

                <li class="nav-list">
                    <!-- ajouter recette -->
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "ajouter")) {
                        echo "class = 'visit'";
                    } ?> href='/recette/ajouter'>Ajouter une recette</a>
                </li>

                <!-- modifier recette -->
                <?php if (strpos($_SERVER['REQUEST_URI'], "modifier")) { ?>
                <li><a class='visit' href=''>Modifier une recette</a></li>

                <?php }

                } ?>


            </ul>

        </div>

        @yield('content')


    </div>

</div>
</body>
</html>

