@extends('layouts/master', ['title' => 'recette'])

@section('content')

    <?php
    if (!empty($oRecipe->id)) {
        $title = "Modification de la recette '" . ucfirst($oRecipe->name) . "'.";
    } else {
        $title = 'Création d\'une nouvelle recette';
    }
    ?>

    <h1>{{ $title }}</h1>


    <form method="post">
        <!-- nom de la recette -->
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Entrez le nom de la recette"
                           value="<?php if (!empty($oRecipe)) {
                               echo $oRecipe->name;
                           }?>" name="sRecipeName"/>
                </div>
            </div>
            <a href="#" class="hidden_delete">X</a>
        </div>

    {{ csrf_field() }}

    <!-- afficher au moins une ligne si j'ai 0 produits-->
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" id="name" class="form-control produit" placeholder="Entrez un produit"
                           name="aProductName[]"/>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <input type="text" value="" id="quantity" class="form-control" name="aQuantity[]"
                           placeholder="Quantité">
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <select class="form-control" id="unit" name="aUnit[]">
                        <option value="">Choisissez l'unité</option>
                        @foreach($aUnitSelect as $unit)
                            <option value="{{ $unit['id'] }}">{{ $unit['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <a href="#" class="hidden_delete">X</a>
        </div>

        <?php if (!empty($oRecipe)) {
        // sinon pour chaque produit de la recette je recupére tous mes produits

        foreach ($aProduct as $key => $product) { ?>

        <input type="hidden" value="<?php echo $oRecipe->id; ?>" name="id">

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" id="name" class="form-control produit" placeholder="Entrez un produit"
                           value="<?php echo $product[0]->name; ?>" name="aProductName[]"/>
                </div>
            </div>


            <div class="col">
                <div class="form-group">
                    <input type="text" value="<?php echo $product[0]->quantity; ?>" id="quantity" class="form-control"
                           name="aQuantity[]" placeholder="Quantité">
                </div>
            </div>

            <?php// dd($aUnit);
            /*
             * afficher la croix de suppression pour supprimer un produit
             * comparer la valeur de ma table d'association avec ma liste d'unité pour select la bonne unité
             *
             * reecrire la fonction de suppression des lignes de produits
             */
            ?>


            <div class="col">
                <div class="form-group">
                    <select class="form-control" id="unit" name="aUnit[]">
                        <?php foreach ($aUnit as $unit) { ?>
                            <option value="{{ $unit['id'] }}"
                            <?php if($oProduct[$key]->id_unit === $unit['id']) { echo "selected"; } ?>

                            >{{ $unit['name'] }}</option>

                        <?php } ?>
                    </select>
                </div>
            </div>
        <a href="#" class="delete">X</a>
        </div>


        <?php }

        } ?>

        <textarea class="form-control" id="summary-ckeditor" name="cooking_recipe"><?php if (!empty($oRecipe->cooking_recipe)) {echo $oRecipe->cooking_recipe;} ?></textarea>



        <div id="container_input"></div>
        <div class="form-group">
            <button type="button" id="add_product" class="btn btn-success">+</button>
        </div>
        <div class="form-group">
            <button type="submit" name="ajouter" class="btn btn-primary">Envoyer</button>
        </div>
    </form>

    <script>
        CKEDITOR.replace('summary-ckeditor');
    </script>

@endsection