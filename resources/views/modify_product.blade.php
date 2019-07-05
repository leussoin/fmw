<?php App\Misc::isAuth(); ?>

@extends('layouts/master', ['title' => 'produit'])

@section('content')

    <h1>Modifier produit '{{ $aProduct[0]->name }}'</h1>

    <form method="post">
        {{ csrf_field() }}
        @foreach($aProduct as $sProduct)
            <input type="hidden" value="{{ $sProduct->id }}" name="id">
            <input type="hidden" id="price" name="fPrice">

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Nom du produit</label>
                        <input type="text" class="form-control produit" placeholder="Entrez un produit"
                               value="{{ $sProduct->name }}" name="sName"/>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label>Prix (estimation du cout)</label>
                        <div>
                            <div class="euros"><img id="euro-vert" class="img-euros" src={{ asset('svg/euros_vide.png') }}></div>
                            <div class="euros"><img id="euro-orange" class="img-euros" src={{ asset('svg/euros_vide.png') }}></div>
                            <div class="euros"><img id="euro-rouge" class="img-euros" src={{ asset('svg/euros_vide.png') }}></div>
                        </div>

                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Calories</label>
                        <input type="text" class="form-control" name="fPrice" value="{{ $sProduct->price }}"
                               placeholder="Entrez son prix">
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="sel2">Selectionnez les mois du produit (maintenez Shift pour en selectionner
                        plusieurs)</label>
                    <select name='aSelectedMonth[]' multiple class="form-control" id="sel2">
                        <?php
                        $sSelected = '';
                        if (!empty($aMonths)) {
                            foreach ($aMonths as $month) {
                                if (!empty($aMonthsProduct)) {
                                    foreach ($aMonthsProduct as $sProductMonth) {
                                        $sSelected = '';
                                        foreach ($sProductMonth as $mois) {
                                            if ($mois == $month->id) {
                                                $sSelected = 'selected';
                                                break;
                                            }
                                        }
                                    }
                                }
                                echo '<option ' . $sSelected . ' value=' . $month->id . '>' . $month->nom . '</option>';
                            }
                        } ?>
                    </select>
                </div>
            </div>

            <div id="container_input"></div>
            <div class="form-group">
                <button type="submit" value="modifier" class="btn btn-primary">Modifier</button>
            </div>
        @endforeach
    </form>
@endsection
