<?php App\Misc::isAuth(); ?>

@extends('layouts/master', ['title' => 'recette'])

@section('content')


    <h1>Lister les recettes</h1>

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
            <th scope="col">ID du propriétaire</th>
            <th scope="col">Supprimer</th>
        </tr>
        </thead>
        <tbody>
        @foreach($aRecipe as $recipe)
            <tr <?php if($recipe->statuscode === 0) {echo "class='table-danger' ";} ?>  id="{{$recipe->id}}">

                <td>{{$recipe->id }}</td>
                <td>{{$recipe->name }}</td>
                <td>{{$recipe->owner }}</td>
                <td>
                    <a data-id="{{ $recipe->id }}" class="suppr-recipe btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-trash">X</span>
                    </a>
                </td>

            </tr>
            </a>

        @endforeach


        </tbody>
    </table>



@endsection