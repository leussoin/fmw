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

    </div>

@endsection