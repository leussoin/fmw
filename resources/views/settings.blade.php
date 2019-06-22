
@extends('layouts/master', ['title' => 'parametres'])

@section('content')

    <h1>Paramétrage pour les utilisateurs</h1>
    <form id="formulaire" method="post">
        {{ csrf_field() }}
        <input type='hidden' name="products" id='products'>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="Login">Nom d'utilisateur</label>
                    <input type="text" class="form-control"
                           value='{{$oUser->name}}'
                           placeholder="Entrez votre nouveau nom d'utilisateur"
                           name="name"/>
                </div>
            </div>


            <div class="col">
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <select name="genre" class="form-control" id="select-gender">
                        <option value="">Veuillez choisir une valeur</option>
                        <option <?php if ($oUser->genre === 'Femme') {
                            echo 'selected';
                        } ?>
                                value="Femme">Femme
                        </option>
                        <option <?php if ($oUser->genre === 'Homme') {
                            echo 'selected';
                        } ?> value="Homme">Homme</option>
                        <option value="Confidentiel">Ne préfére pas répondre</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="Login">Mot de passe</label>
                    <input type="password" class="form-control"
                           id="password"
                           placeholder="Entrez votre nouveau mot de passe"
                           name="passwd"/>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="Login">Validez votre mot de passe</label>
                    <input type="password" class="form-control"
                           id="confirm-password"
                           placeholder="Confirmez votre mot de passe"
                           name="passwd"/>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="produit">Quels aliments n'appréciez vous pas ?</label>
                    <input type="text" id="produit" class="form-control">
                </div>
            </div>


            <div class="col">Toto
                <div id="div-textarea">
                    <?php
                    if (!empty($aProduct)) {
                        foreach ($aProduct as $product) {

                            echo "<span class='box-product'>" . $product . "<i class='delete far fa-window-close'></i></span>";
                        }
                    } ?></div>
            </div>
        </div>
        <?php //dd($oUser->will); ?>
        <div class="col">
            <div class="form-group">
                <label for="selectWill">Volonté: ce réglage permet d'adapter les suggestion des plats selon votre
                    volontée d'assainir votre alimentation : 1 = débuttant / 5 = mode hardcore :)</label>
                <select name="will" class="form-control" id="select-will">
                    <option value="">Veuillez choisir une valeur</option>
                    <option <?php if ($oUser->will === 1) {echo 'selected=selected';} ?> value="1">Le gras c'est la vie</option>
                    <option <?php if ($oUser->will === 2) {echo 'selected=selected';} ?> value="2">Bon, pas plus de 100 grammes de rapé dans mes pates</option>
                    <option <?php if ($oUser->will === 3) {echo 'selected=selected';} ?> value="3">Et si on réduisait la viande ?</option>
                    <option <?php if ($oUser->will === 4) {echo 'selected=selected';} ?> value="4">C'est l'heure des grandes résolutions</option>
                    <option <?php if ($oUser->will === 5) {echo 'selected=selected';} ?> value="5">A moi les tablettes, et pas en chocolat !</option>

                </select>
            </div>
        </div>


        <div class="form-group">
            <button type="submit" id="save" name="save" class="btn btn-primary">Sauvegarder</button>
        </div>
    </form>




@endsection