<?php App\Misc::isAuth(); ?>

@extends('layouts/master', ['title' => 'parametres'])

@section('content')

    <h1>Paramétrage pour les utilisateurs AAAAAAAAAAAAAAAAAAAAAAAAAAAAAARGGGGGGGGGGGH</h1>
    <form method="post">
        {{ csrf_field() }}
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
                    <label for="exampleFormControlSelect1">Genre</label>
                    <select class="form-control" id="select-gender">
                        <option value="">Veuillez choisir une valeur</option>
                        <option value="Femme">Femme</option>
                        <option value="Homme">Homme</option>
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
                           id="Entre votre nouveau nom d'utilisateur"
                           placeholder="Entre votre nouveau nom d'utilisateur"
                           name="passwd"/>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="Login">Validez votre mot de passe</label>
                    <input type="password" class="form-control"
                           placeholder="Entre votre nouveau nom d'utilisateur"
                           name="passwd"/>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Quels aliments n'appréciez vous pas ?</label>
                    <input type="text" id="produit" class="form-control">
                </div>
            </div>




            <div class="col">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Liste d'ingrédients</label>
                    <textarea id="liste-ingredients" class="form-control"></textarea>
                    </select>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="selectWill">Volonté: ce réglage permet d'adapter les suggestion des plats selon votre volontée d'assainir votre alimentation : 1 = débuttant / 5 = mode hardcore :)</label>
                <select class="form-control" id="select-gender">
                    <option value="">Veuillez choisir une valeur</option>
                    <option value="1">Le gras c'est la vie</option>
                    <option value="2">Bon, pas plus de 100 grammes de rapé dans mes pates</option>
                    <option value="3">C'est l'heure des grandes résolutions</option>
                    <option value="4">Et si on réduisait la viande ?</option>
                    <option value="5">A moi les plaquettes, et pas en chocolat :)</option>

                    <option value="Confidentiel">Ne préfére pas répondre</option>

                </select>
            </div>
        </div>





        <div class="form-group">
            <button type="submit" name="ajouter" class="btn btn-primary">Sauvegarder</button>
        </div>
    </form>




@endsection