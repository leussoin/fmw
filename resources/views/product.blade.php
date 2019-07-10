<?php App\Misc::isAuth(); ?>

@extends('layouts/master', ['title' => 'produit'])
@section('content')

    <?php

    if (empty($aProduct->id)) { ?>
    <h1>Ajoutez un produit</h1>
    <?php } else { ?>
    <h1>Modifier produit '{{ $aProduct->name }}'</h1>
    <?php } ?>

    <form method="post" id="form-product">
        {{ csrf_field() }}
        <input type="hidden" value="<?php if(!empty($aProduct->price)){echo $aProduct->price;}?>" id="price" name="price">

        <?php if (!empty($aProduct)) { ?>

        <input type="hidden" value="<?php if(!empty($aProduct->id)){echo $aProduct->id;} ?>" name="id">

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Nom du produit</label>
                    <input type="text" class="form-control produit" placeholder="Entrez un produit"
                           value="{{ $aProduct->name }}" name="sName"/>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label>Prix (estimation du cout)</label>

                    <?php if ($aProduct->price == 1) { ?>
                    <div>
                        <div class="euros"><img id="euro-vert" class="img-euros"
                                                src={{ asset('svg/euros_vert.png') }}></div>
                        <div class="euros"><img id="euro-orange" class="img-euros"
                                                src={{ asset('svg/euros_vide.png') }}></div>
                        <div class="euros"><img id="euro-rouge" class="img-euros"
                                                src={{ asset('svg/euros_vide.png') }}></div>
                    </div>
                    <?php } elseif ($aProduct->price == 2) { ?>
                    <div>
                        <div class="euros"><img id="euro-vert" class="img-euros"
                                                src={{ asset('svg/euros_vert.png') }}></div>
                        <div class="euros"><img id="euro-orange" class="img-euros"
                                                src={{ asset('svg/euros_orange.png') }}></div>
                        <div class="euros"><img id="euro-rouge" class="img-euros"
                                                src={{ asset('svg/euros_vide.png') }}></div>
                    </div>
                    <?php } elseif ($aProduct->price == 3) { ?>
                    <div>
                        <div class="euros"><img id="euro-vert" class="img-euros"
                                                src={{ asset('svg/euros_vert.png') }}></div>
                        <div class="euros"><img id="euro-orange" class="img-euros"
                                                src={{ asset('svg/euros_orange.png') }}></div>
                        <div class="euros"><img id="euro-rouge" class="img-euros"
                                                src={{ asset('svg/euros_rouge.png') }}></div>
                    </div>
                    <?php }  ?>

                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label>Calories</label>
                    <input type="text" id="cal" class="form-control" name="iCal" value="{{ $aProduct->cal }}"
                           placeholder="Entrez son prix">
                </div>
            </div>
        </div>

        <div class="row">

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
                                    foreach ($aMonthsProduct as $aProductMonth) {
                                        $sSelected = '';
                                        foreach ($aMonthsProduct as $mois) {
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
        </div>

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
                    <input type="text" id="cal" class="form-control" name="aCaloriesProduit[]"
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
            <?php if (empty($aProduct->id)) { ?>
            <button type="submit" value="ajouter" class="btn btn-primary">Ajouter</button>
            <?php } else { ?>
            <button type="submit" value="modifier" class="btn btn-primary">Modifier</button>
            <?php } ?>
        </div>

    </form>
@endsection