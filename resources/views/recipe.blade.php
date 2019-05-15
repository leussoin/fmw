<?php App\Misc::isAuth(); ?>

@extends('layouts/master', ['title' => 'recipe'])
@section('content')

    <h1>Ici créez une recette</h1>
    <a href='/menu'>Revenir en arriére</a>
    <br>
    <br>

    <form method="post">
        {{ csrf_field() }}

        <div class="form-group">
            <input type="text" class="form-control" name="nom_recette" placeholder="Entrez le nom de la recette">
        </div>
        <div class="form-group">
            <input type="text" class="produit form-control" name="aIngredient[]" placeholder="Entrez un ingrédient">
        </div>
        <div id="container_input"></div>
        <div class="form-group">
            <button type="button" id="ajouter_ingredient" class="btn btn-success">+</button>
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