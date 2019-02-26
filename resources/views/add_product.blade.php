@extends('layouts/master', ['title' => 'produit'])

@section('content')
    <h1>Ajoutez des produits</h1>


    <?php
    if (!empty($aProduit)) {
        var_dump($aProduit);
    }
    ?>

    <form method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control produit" placeholder="Entrez un produit"
                           name="aNomProduit[]"/>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" name="aPrixProduit[]" placeholder="Entrez son prix">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" name="aCaloriesProduit[]"
                           placeholder="Entrez sa valeur calorifique">
                </div>
            </div>


            <a href="#" id="hidden_delete">X</a>
        </div>
        <div id="container_input"></div>
        <div class="form-group">
            <button type="button" id="ajouter_produit" class="btn btn-success">+</button>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <?php
    if (!empty($aIngredient)) {
        foreach ($aIngredient as $ingredient) {
            if (!empty($ingredient)) {
                echo "Ingrédient  : " . $ingredient;
                echo "<br>";
            }
        }
    }
    ?>

@endsection