<?php App\Misc::isAuth(); ?>

@extends('layouts/master', ['title' => "menu"])
@section('content')

    <h1>Coucou <?php echo $oUser->name; ?> bien ou bien ?
        <button name="button" value="save" type="submit">Sauvegarder la semaine</button>

        <!--<button type="button" id="calcul">Calculer les calories</button> -->
    </h1>
    <form method="post">
        {{ csrf_field() }}

        <div>
            <button class="inline-item" name="button" value="-" id="-"><</button>
            <h2 class="inline-item">Nous sommes le <?php echo date('d-m-Y'); $jourDeLaSemaine = date('N');?></h2>
            <button class="inline-item" name="button" value="+" id="+">></button>

        </div>


        <table class="table">
            <thead>
            <th></th>
            <th>Midi</th>
            <th>Soir</th>
            <th class="cal">Calories</th>

            </thead>

            <tr <?php if ($jourDeLaSemaine == '1' && $aSemaine[1] == date('d-m-Y')) {
                echo 'class="current-day";';
            } ;?>>
                <td>Lundi {{$aSemaine[1]}}</td>
                <input type="hidden" name="first-day" value="{{$aSemaine[1]}}">
                <td>
                    <input type="text" name="midi[]" value="<?php if (!empty($aPlatUser['midi'][1])) {
                        echo $aPlatUser['midi'][1];
                    } ?>" id="i-lm" class="input lu">

                </td>
                <td><input type="text" name="soir[]" value="<?php if (!empty($aPlatUser['soir'][1])) {
                        echo $aPlatUser['soir'][1];
                    } ?>" id="i-ls" class="input lu">
                </td>
                <td><input id="lu" class="cal" type="text"></td>
            </tr>

            <tr <?php if ($jourDeLaSemaine == '2' && $aSemaine[2] == date('d-m-Y')) {
                echo 'class="current-day";';
            } ;?> >
                <td>Mardi {{$aSemaine[2]}}</td>
                <td><input type="text" name="midi[]" value="<?php if (!empty($aPlatUser['midi'][2])) {
                        echo $aPlatUser['midi'][2];
                    } ?>" id="i-mam" class="input ma">
                </td>
                <td><input type="text" name="soir[]" value="<?php if (!empty($aPlatUser['soir'][2])) {
                        echo $aPlatUser['soir'][2];
                    } ?>" id="i-mas" class="input ma">
                </td>
                <td><input id="ma" class="cal" type="text"></td>

            </tr>

            <tr <?php if ($jourDeLaSemaine == '3' && $aSemaine[3] == date('d-m-Y')) {
                echo 'class="current-day";';
            } ;?> >
                <td>Mercredi {{$aSemaine[3]}}</td>
                <td><input type="text" name="midi[]" value="<?php if (!empty($aPlatUser['midi'][3])) {
                        echo $aPlatUser['midi'][3];
                    } ?>" id="i-mem" class="input mer">
                </td>
                <td><input type="text" name="soir[]" value="<?php if (!empty($aPlatUser['soir'][3])) {
                        echo $aPlatUser['soir'][3];
                    } ?>" id="i-mes" class="input mer">
                </td>
                <td><input id="mer" class="cal" type="text"></td>

            </tr>

            <tr <?php if ($jourDeLaSemaine == '4' && $aSemaine[4] == date('d-m-Y')) {
                echo 'class="current-day";';
            } ;?> >
                <td>Jeudi {{$aSemaine[4]}}</td>
                <td><input type="text" name="midi[]" value="<?php if (!empty($aPlatUser['midi'][4])) {
                        echo $aPlatUser['midi'][4];
                    } ?>" id="i-jm" class="input jeu">
                </td>
                <td><input type="text" name="soir[]" value="<?php if (!empty($aPlatUser['soir'][4])) {
                        echo $aPlatUser['soir'][4];
                    } ?>" id="i-js" class="input jeu">
                </td>
                <td><input id="jeu" class="cal" type="text"></td>

            </tr>

            <tr <?php if ($jourDeLaSemaine == '5' && $aSemaine[5] == date('d-m-Y')) {
                echo 'class="current-day";';
            } ;?> >
                <td>Vendredi {{$aSemaine[5]}}</td>
                <td><input type="text" name="midi[]" value="<?php if (!empty($aPlatUser['midi'][5])) {
                        echo $aPlatUser['midi'][5];
                    } ?>" id="i-vm" class="input ven">
                </td>
                <td><input type="text" name="soir[]" value="<?php if (!empty($aPlatUser['soir'][5])) {
                        echo $aPlatUser['soir'][5];
                    } ?>" id="i-vs" class="input ven">
                </td>
                <td><input id="ve" class="cal" type="text"></td>

            </tr>

            <tr <?php if ($jourDeLaSemaine == '6' && $aSemaine[6] == date('d-m-Y')) {
                echo 'class="current-day";';
            } ;?> >
                <td>Samedi {{$aSemaine[6]}}</td>
                <td><input type="text" id="i-sm" value="<?php if (!empty($aPlatUser['midi'][6])) {
                        echo $aPlatUser['midi'][6];
                    } ?>" name="midi[]" class="input sam">
                </td>
                <td><input type="text" id="i-ss" name="soir[]" value="<?php if (!empty($aPlatUser['soir'][6])) {
                        echo $aPlatUser['soir'][6];
                    } ?>" class="input sam">
                </td>
                <td><input id="sam" class="cal" type="text"></td>

            </tr>

            <tr <?php if ($jourDeLaSemaine == '7' && $aSemaine[7] == date('d-m-Y')) {
                echo 'class="current-day"';
            } ;?> >
                <td>Dimanche {{$aSemaine[7]}}</td>
                <td><input type="text" id="i-dm" value="<?php if (!empty($aPlatUser['midi'][7])) {
                        echo $aPlatUser['midi'][7];
                    } ?>" name="midi[]" class="input dim">
                </td>
                <td><input type="text" id="i-ds" name="soir[]" value="<?php if (!empty($aPlatUser['soir'][7])) {
                        echo $aPlatUser['soir'][7];
                    } ?>" class="input dim">
                </td>
                <td><input id="dim" class="cal" type="text"></td>

            </tr>

            <tr>
                <td>Total</td>
                <td></td>
                <td></td>
                <td><input id="total" type="text"></td>

            </tr>

        </table>


    </form>



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
