<?php App\Misc::isAuth(); ?>

@extends('layouts/master', ['title' => 'produit'])

@section('content')
    <div class=".col-xs-6 .col-sm-4 centered">

        <h1>Lister les produits</h1>

        Afficher les produits supprimés
        <label class="switch">
            <input type="checkbox" id="checkbox_deleted_products">
            <span class="slider"></span>
        </label>

        <input type="hidden" id="token" value="{{ csrf_token() }}">


        <table class="datatable">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Valeur calorifique</th>
                <th scope="col">Prix</th>
                <th scope="col">Mois</th>
                <th scope="col">Supprimer</th>
            </tr>
            </thead>
            <tbody>

            <?php

            foreach($aProduct as $produit) {
                var_dump($produit);
                ?>
            <tr id="<?php echo $produit->id;?>">

                <td><?php echo $produit->id;?></td>
                <td><?php echo $produit->name;?></td>
                <td><?php echo $produit->cal;?></td>
                <td><?php echo $produit->price;?></td>
                <td><?php
                    if (!empty($aSeasonProduct[$produit->id])) {
                        foreach ($aSeasonProduct[$produit->id] as $month) {
                            var_dump($produit);

                            if ($month == (int)date('m')) {
                                echo ":)";
                            } else {

                                echo ":(";
                            }
                        }
                    }
                    // pour chaque mois
                    // si le mois en cours = un des mois de la liste :) sinon :(
                    ?></td>
                <td>
                    <a data-id="{{ $produit->id }}" class="suppr-produit btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-trash"></span> X
                    </a>
                </td>

            </tr>
            </a>

            <?php } ?>


            </tbody>
        </table>


@endsection