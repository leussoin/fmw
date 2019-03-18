@extends('layouts/master', ['title' => 'recette'])

@section('content')

    <h1>Ajoutez vos recettes</h1>



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

        <?php

        if (empty($oRecipe)) { ?>

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
                        @foreach($aUnitSelect as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <a href="#" class="hidden_delete">X</a>
        </div>


        <?php } else {
        // sinon pour chaque produit de la recette je recupére tous mes produits

        foreach ($aProduct as $product) { ?>

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
                        @foreach($aUnitSelect as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <a href="#" class="hidden_delete">X</a>
        </div>

    <?php }

        } ?>

        <div id="container_input"></div>
        <div class="form-group">
            <button type="button" id="add_product" class="btn btn-success">+</button>
        </div>
        <div class="form-group">
            <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
        </div>
    </form>

@endsection