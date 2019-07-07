<?php App\Misc::isAuth(); ?>

@extends('layouts/master', ['title' => 'recette'])

@section('content')
    <?php if (!empty($oRecipe->id)) {
        $title = "Modification de la recette '" . ucfirst($oRecipe->name) . "'.";
    } else {
        $title = "Création d'une nouvelle recette";
    }
    ?>

    <h1>{{ $title }}</h1>


    <form id="form-recipe" method="post">
        <!-- nom de la recette -->
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Nom de la recette</label>
                    <input type="text"
                           id="recipeName"
                           class="form-control"
                           placeholder="Entrez le nom de la recette"
                           value="<?php if (!empty($oRecipe)) { echo $oRecipe->name; }?>"
                           name="sRecipeName"
                    />
                </div>
            </div>

            <?php if (!empty($oRecipe->id)) { ?>

            <div class="col">
                <div class="form-group">
                    <label>Valeur calorifique</label>
                    <input disabled type="text" class="form-control" placeholder="Valeur calorifique"
                           value="<?php if (!empty($oRecipe->total_calorie)) {
                               echo $oRecipe->total_calorie;
                           }?>" name="iTotalCal"/>
                </div>
            </div>
            <?php } ?>


            <a href="#" class="hidden_delete">X</a>
        </div>

        {{ csrf_field() }}
        <span>Liste des produits de la recette</span>
        <!-- afficher au moins une ligne si j'ai 0 produits-->
        <div class="row">
            <div class="col">
                <label>Nom du produit</label>
                <div class="form-group">
                    <input type="text"
                           id="name"
                           class="form-control produit"
                           placeholder="Entrez un produit"
                           name="aProductName[]"
                    />
                </div>
            </div>
            <div class="col">
                <label>Quantité</label>
                <div class="form-group">
                    <input type="text"
                           id="quantity"
                           class="form-control quantity"
                           name="aQuantity[]"
                           placeholder="Quantité">
                </div>
            </div>

            <div class="col">
                <label>Unité</label>
                <div class="form-group">
                    <select class="form-control unit-select" id="unit" name="aUnit[]">
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


            <div class="col">
                <div class="form-group">
                    <select class="form-control" id="unit" name="aUnit[]">
                        <?php foreach ($aUnit as $unit) { ?>
                        <option value="{{ $unit['id'] }}"
                        <?php if ($oProduct[$key]->id_unit === $unit['id']) {
                            echo "selected";
                        } ?>

                        >{{ $unit['name'] }}</option>

                        <?php } ?>
                    </select>
                </div>
            </div>
            <a href="#" class="delete">X</a>
        </div>


        <?php }

        } ?>

        <div id="container_input"></div>
        <div class="form-group">
            <button type="button" id="add_product" class="btn btn-success">+</button>
        </div>


        <span>Procédure de la recette</span>

        <textarea class="form-control" id="summary-ckeditor"
                  name="cooking_recipe"><?php if (!empty($oRecipe->cooking_recipe)) {
                echo $oRecipe->cooking_recipe;
            } ?></textarea>


        <div class="form-group">
            <button type="submit" name="ajouter" class="btn btn-primary">Envoyer</button>
        </div>
    </form>

    <script>
        CKEDITOR.replace('summary-ckeditor');
    </script>

@endsection