@extends('layouts/master', ['title' => 'recette'])

@section('content')
Ici j'ai la liste de mes recettes oué !



<div class=".col-xs-6 .col-sm-4 centered">

    <h1>Lister les produits</h1>

    Afficher les produits supprimés
    <label class="switch">
        <input type="checkbox" id="checkbox_deleted_products">
        <span class="slider"></span>
    </label>

    <input type="hidden" id="token" value="{{ csrf_token() }}">


    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">ID du propriétaire</th>
            <th scope="col">Supprimer</th>
        </tr>
        </thead>
        <tbody>
        @foreach($aRecipe as $recipe)
            <tr id="{{$recipe->id}}">

                <td>{{$recipe->id }}</td>
                <td>{{$recipe->name }}</td>
                <td>{{$recipe->owner }}</td>
                <td>
                    <a data-id="{{ $recipe->id }}" class="suppr-recipe btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-trash"></span> X
                    </a>
                </td>

            </tr>
            </a>

        @endforeach


        </tbody>
    </table>



@endsection