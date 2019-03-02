<!doctype html>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>FMW - {{ ucfirst($title) }}</title>
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

<!!-- scripts pour bouton togle options ON / OFF -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript" src="{{ URL::asset("js/global.js") }}"></script>
<script type="text/javascript" src="{{ URL::asset("js/$title.js") }}"></script>

<link rel="stylesheet" href="{{ URL::asset("css/global.css") }}"/>
<link rel="stylesheet" href="{{ URL::asset("css/$title.css") }}"/>


<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="container">

    <div class=".col-xs-6 .col-sm-4 centered">

        <!-- menu de navigation -->
        <div class="nav-container">
            <ul class="nav-list">
                <li>
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "menu")) {
                        echo "class = 'visit'";
                    } ?> href='/menu'>Menu</a>
                </li>

                <li>
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "produit")) {
                        echo "class = 'visit'";
                    } ?> href='/produit/lister'>Produit</a>
                </li>

                <li>
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "recette")) {
                        echo "class = 'visit'";
                    } ?> href='/recette/lister'>Recette</a>
                </li>

            </ul>


            <ul class="nav-list">

                <!-- menu des produits -->
                <?php if (strpos($_SERVER['REQUEST_URI'], "produit")) { ?>

                <li>
                    <!-- si on à le mot clef menu + list_product -->
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "produit/lister")) {
                        echo "class = 'visit'";
                    } ?> href='/produit/lister'>Lister les produits</a>
                </li>

                <li>
                    <!-- si on à le mot clef menu + ajouter produit -->
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "ajouter")) {
                        echo "class = 'visit'";
                    } ?> href='/produit/ajouter'>Ajouter un produit</a>
                </li>
                <!-- ajouter la condition modifier -->

                <?php if (strpos($_SERVER['REQUEST_URI'], "modifier")) { ?>

                <li>
                    <!-- si on à le mot clef menu + ajouter produit -->
                    <a class='visit' href=''>Modifier un produit</a>
                </li>
                <?php }
                } ?>


            <!-- menu des recettes -->
                <?php if (strpos($_SERVER['REQUEST_URI'], "recette")) { ?>

                <li>
                    <!-- si on à le mot clef menu + list_product -->
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "lister")) {
                        echo "class = 'visit'";
                    } ?> href='/recette/lister'>Lister les recettes</a>
                </li>

                <li>
                    <!-- si on à le mot clef menu + ajouter produit -->
                    <a <?php if (strpos($_SERVER['REQUEST_URI'], "ajouter")) {
                        echo "class = 'visit'";
                    } ?> href='/recette/ajouter'>Ajouter une recette</a>
                </li>

                <?php } ?>


            </ul>
        </div>

        @yield('content')


    </div>

</div>
</body>
</html>

