<?php App\Misc::isAuth(); ?>


@extends('layouts/master', ['title' => 'restes'])

@section('content')

    <div class="container">

        <div class=".col-xs-6 .col-sm-4 centered">

            <form method="POST">
                <input type='hidden' name="products" id='products'>

                {{ csrf_field() }}


                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="produit">Insérez des produits</label>
                            <input type="text" id="produit" class="form-control">
                        </div>
                    </div>

                    <div class="col">Liste de produits pour tenter de récupérer des recettes !
                        <div id="div-textarea">
                            <?php
                            if (!empty($aProduct)) {
                                foreach ($aProduct as $product) {
                                    echo "<span class='box-product'>" . $product . "<i class='delete far fa-window-close'></i></span>";
                                }
                            } ?></div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <input type="hidden" id="token" value="{{ csrf_token() }}">

        <?php if (!empty($aRecipe)) { ?>
        <table class="datatable">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Supprimer</th>
            </tr>
            </thead>
            <tbody>
            <?php //dd($aRecipe); ?>
            @foreach($aRecipe as $id => $recipe)
                <a href="">
                    <tr>

                        <td>{{$id }}</td>
                        <td>{{$recipe}}</td>
                        <td>
                            <a data-id="{{ $id }}" class="suppr-recipe btn btn-info btn-sm">
                                <span class="glyphicon glyphicon-trash">X</span>
                            </a>
                        </td>

                    </tr>
                </a>

            @endforeach


            </tbody>
        </table>
        <?php } ?>
    </div>

@endsection