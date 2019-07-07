<?php App\Misc::isAuth(); ?>

@extends('layouts/master', ['title' => 'recette'])

@section('content')

    <input type="text" value="{{ !empty($sProduct->price) }}" id="price" name="price">

    <h1>Lister les recettes</h1>

    Afficher les produits supprimés
    <label class="switch">
        <input type="checkbox" id="checkbox_deleted_products">
        <span class="slider"></span>
    </label>

    <form>
        <input type="hidden" id="token" value="{{ csrf_token() }}">

        <div>
            <button type="submit" name="selectedPrice" value="1">
                <div class="euros"><img id="euro-vert" class="img-euros" src={{ asset('svg/euros_vide.png') }}></div>
            </button>
            <button type="submit" name="selectedPrice" value="2">
                <div class="euros"><img id="euro-orange" class="img-euros" src={{ asset('svg/euros_vide.png') }}></div>
            </button>
            <button type="submit" name="selectedPrice" value="3">
                <div class="euros"><img id="euro-rouge" class="img-euros" src={{ asset('svg/euros_vide.png') }}></div>
            </button>
        </div>


    </form>



    <?php if (!empty($aRecipe)) { ?>
    <table class="datatable">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">ID du propriétaire</th>
            <th scope="col">Prix</th>
            <th scope="col">Supprimer</th>
        </tr>
        </thead>
        <tbody>
        @foreach($aRecipe as $recipe)
            <a href="">
                <tr <?php if ($recipe->statuscode === 0) { echo "class='table-danger' "; } ?>  id="{{$recipe->id}}">
                    <td>{{$recipe->id }}</td>
                    <td>{{$recipe->name }}</td>
                    <td>{{$recipe->owner }}</td>

                    <td>
                        <?php
                        if ($recipe->price == 1) { ?>
                        <div class="euros"><img class="img-euros" src={{ asset('svg/euros_vert.png') }}></div>
                        <?php } elseif ($recipe->price == 2) { ?>
                        <div class="euros"><img class="img-euros" src={{ asset('svg/euros_orange.png') }}></div>
                        <?php } elseif ($recipe->price == 3) { ?>
                        <div class="euros"><img class="img-euros" src={{ asset('svg/euros_rouge.png') }}></div>
                        <?php } ?>
                    </td>

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
    <?php } ?>



@endsection