<?php App\Misc::isAuth(); ?>

@extends('layouts/master', ['title' => 'produit'])

@section('content')

    <h1>Ajoutez des produits</h1>

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
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="sel2">Selectionnez les mois du produit (maintenez Shift pour en selectionner
                        plusieurs)</label>
                    <select name='aSeason[]' multiple class="form-control" id="sel2">
                        <?php if (!empty($aMonths)) { ?>
                        @foreach ($aMonths as $months)
                            <option value='{{$months->id}}'>{{$months->nom}}</option>
                        @endforeach
                        <?php } ; ?>
                    </select>
                </div>
            </div>
        </div>
        <a href="#" class="hidden_delete">X</a>

        <div id="container_input"></div>
        <!--<div class="form-group">
            <button type="button" id="ajouter_produit" class="btn btn-success">+</button>
        </div> -->
        <div class="form-group">
            <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
        </div>
    </form>

@endsection