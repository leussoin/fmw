<?php App\Misc::isAuth(); ?>

@extends('layouts/master', ['title' => "menu"])
@section('content')

    <h1>Coucou <?php echo $oUser->name; ?> bien ou bien ?</h1>
    <table class="table">
        <thead>
        <th></th>
        <th>Midi</th>
        <th>Soir</th>
        <th class="cal">Calories</th>
        </thead>

        <tr>
            <td>Lundi</td>
            <td><input type="text" id="i-lm" class="input"><button class="modale" id="lm"><i class="fas fa-utensils"></i></button></td>
            <td><input type="text" id="i-ls" class="input"><button class="modale" id="ls"><i class="fas fa-utensils"></i></button></td>
            <td><input class="cal" type="text"></td>
        </tr>

        <tr>
            <td>Mardi</td>
            <td><input type="text" id="i-mam" class="input"><button class="modale" id="mam"><i class="fas fa-utensils"></i></button></td>
            <td><input type="text" id="i-mas" class="input"><button class="modale" id="mas"><i class="fas fa-utensils"></i></button></td>
            <td><input class="cal"type="text"></td>

        </tr>

        <tr>
            <td>Mercredi</td>
            <td><input type="text" id="i-mem" class="input" ><button class="modale" id="mem"><i class="fas fa-utensils"></i></button></td>
            <td><input type="text" id="i-mes" class="input" ><button class="modale" id="mes"><i class="fas fa-utensils"></i></button></td>
            <td><input class="cal" type="text"></td>

        </tr>

        <tr>
            <td>Jeudi</td>
            <td><input type="text" id="i-jm" class="input"><button class="modale" id="jm"><i class="fas fa-utensils"></i></button></td>
            <td><input type="text" id="i-js" class="input"><button class="modale" id="js"><i class="fas fa-utensils"></i></button></td>
            <td><input class="cal" type="text"></td>

        </tr>

        <tr>
            <td>Vendredi</td>
            <td><input type="text" id="i-vm" class="input"><button class="modale" id="vm"><i class="fas fa-utensils"></i></button></td>
            <td><input type="text" id="i-vs" class="input"><button class="modale" id="vs"><i class="fas fa-utensils"></i></button></td>
            <td><input class="cal" type="text"></td>

        </tr>

        <tr>
            <td>Samedi</td>
            <td><input type="text" id="i-sm" class="input"><button class="modale" id="sm"><i class="fas fa-utensils"></i></button></td>
            <td><input type="text" id="i-ss" class="input"><button class="modale" id="ss"><i class="fas fa-utensils"></i></button></td>
            <td><input class="cal" type="text"></td>

        </tr>


        <tr>
            <td>Dimanche</td>
            <td><input type="text" id="i-dm" class="input"><button class="modale" id="dm"><i class="fas fa-utensils"></i></button></td>
            <td><input type="text" id="i-ds" class="input"><button class="modale" id="ds"><i class="fas fa-utensils"></i></button></td>
            <td><input class="cal" type="text"></td>

        </tr>

    </table>





    <div class="bs-example">
        <div id="myModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un plat</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Selectionnez un plat</p>
                        <input type="text" id="recette">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" id="ajouter" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
