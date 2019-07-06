<?php App\Misc::isAuth(); ?>

@extends('layouts/master', ['title' => 'produit'])
@section('content')

    <?php if (empty($sProduct->id)) { ?>
    <h1>Ajoutez un produit</h1>
    <?php } else { ?>
    <h1>Modifier produit '{{ $aProduct[0]->name }}'</h1>
    <?php } ?>
    <form method="post">
        {{ csrf_field() }}
        <?php if (!empty($aProduct)) { ?>
        @foreach($aProduct as $sProduct)
            <input type="hidden" value="{{ !empty($sProduct->id) }}" name="id">
            <input type="hidden" value="{{ !empty($sProduct->price) }}" id="price" name="price">

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
                            <div class="euros"><img id="euro-vert" class="img-euros"
                                                    src={{ asset('svg/euros_vide.png') }}></div>
                            <div class="euros"><img id="euro-orange" class="img-euros"
                                                    src={{ asset('svg/euros_vide.png') }}></div>
                            <div class="euros"><img id="euro-rouge" class="img-euros"
                                                    src={{ asset('svg/euros_vide.png') }}></div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label>Calories</label>
                        <input type="text" class="form-control" name="iCal" value="{{ $sProduct->cal }}"
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

        @endforeach
        <?php } else { ?>

        <div class="row">
            <div class="col">
                <label>Nom du produit</label>

                <div class="form-group">
                    <input type="text" class="form-control produit" placeholder="Entrez un produit"
                           name="aNomProduit[]"/>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label>Prix (estimation du cout)</label>
                    <div>
                        <div class="euros"><img id="euro-vert" class="img-euros"
                                                src={{ asset('svg/euros_vide.png') }}></div>
                        <div class="euros"><img id="euro-orange" class="img-euros"
                                                src={{ asset('svg/euros_vide.png') }}></div>
                        <div class="euros"><img id="euro-rouge" class="img-euros"
                                                src={{ asset('svg/euros_vide.png') }}></div>
                    </div>
                </div>
            </div>

            <div class="col">
                <label>Calories</label>
                <div class="form-group">
                    <input type="text" class="form-control" name="aCaloriesProduit[]"
                           placeholder="Entrez sa valeur calorifique">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="sel2">Selectionnez les mois du produit (maintenez Shift pour en selectionner
                        plusieurs)</label>
                    <select name='aSeason[]' multiple class="form-control" id="sel2">
                        <?php if (!empty($aMonths)) { ?>
                        @foreach ($aMonths as $months)
                            <option value='{{$months->id}}'>{{$months->nom}}</option>
                        @endforeach
                        <?php } ; ?>
                    </select>
                </div>
            </div>
        </div>


        <?php } ?>
        <div id="container_input"></div>
        <div class="form-group">
            <button type="submit" value="modifier" class="btn btn-primary">Modifier</button>
        </div>

    </form>














@endsection