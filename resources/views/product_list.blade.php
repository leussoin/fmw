
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
            <th scope="col">Supprimer</th>
        </tr>
        </thead>
        <tbody>
        @foreach($aProduct as $produit)
            <tr id="{{$produit->id}}">

                <td>{{ $produit->id }}</td>
                <td>{{ $produit->name }}</td>
                <td>{{ $produit->cal }}</td>
                <td>{{ $produit->price }}</td>
                <td>
                    <a data-id="{{ $produit->id }}" class="suppr-produit btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-trash"></span> X
                    </a>
                </td>

            </tr>
            </a>

        @endforeach


        </tbody>
    </table>


@endsection