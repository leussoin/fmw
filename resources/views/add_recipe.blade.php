@extends('layouts/master', ['title' => 'recette'])

@section('content')

    <h1>Ajoutez vos recettes</h1>

    <form method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Entrez le nom de la recette"
                           name="sRecipeName"/>
                </div>
            </div>
            <a href="#" class="hidden_delete">X</a>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control produit" placeholder="Entrez un produit"
                           name="aProductName[]"/>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" name="aQuantity[]" placeholder="Quantité">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <select class="form-control" name="aUnit[]">
                        <option>Default select</option>
                    </select>
                </div>
            </div>
            <a href="#" class="hidden_delete">X</a>
        </div>
        <div id="container_input"></div>
        <div class="form-group">
            <button type="button" id="add_product" class="btn btn-success">+</button>
        </div>
        <div class="form-group">
            <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
        </div>
    </form>





@endsection