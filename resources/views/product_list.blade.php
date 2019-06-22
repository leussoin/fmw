<?php App\Misc::isAuth(); ?>

@extends('layouts/master', ['title' => 'produit'])

@section('content')

    <?php
    //dd($aSeasonProduct[45]);


    ?>


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

            <?php echo date('m');

            foreach($aProduct as $produit) { ?>
            <tr id="<?php echo $produit->id;?>">

                <td><?php echo $produit->id;?></td>
                <td><?php echo $produit->name;?></td>
                <td><?php echo $produit->cal;?></td>
                <td><?php echo $produit->price;?></td>
                <td><?php
                    if (!empty($aSeasonProduct[$produit->id])) {
                        foreach ($aSeasonProduct[$produit->id] as $month) {
                            if ($month == date('m')) {
                                echo ":)";
                                break;
                            } else {
                                echo ":(";
                                break;
                            }
                        }
                    }
                    // pour chaque mois
                    // si le mois en cours = un des mois de la liste :) sinon :(
                    ?></td>
                <td>{{ $produit->price }}</td>
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