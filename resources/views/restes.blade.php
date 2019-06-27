<?php App\Misc::isAuth(); ?>


@extends('layouts/master', ['title' => 'restes'])

@section('content')

    <div class="container">

        <div class=".col-xs-6 .col-sm-4 centered">

            <form method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="Login">Entrez des produits, séparés par une virgule (",")</label>
                    <input type="text" class="form-control" name="products" aria-describedby="Login" placeholder="Entrez votre login">
                </div>



                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="produit">Quels aliments n'appréciez vous pas ?</label>
                            <input type="text" id="produit" class="form-control">
                        </div>
                    </div>


                    <div class="col">Liste de produits que vous ne souhaitez pas voir dans les suggestions de recettes
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