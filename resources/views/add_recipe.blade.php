@extends('layouts/master', ['title' => 'recette'])

@section('content')

    <h1>Ajoutez vos recettes</h1>

    <form method="post">
        {{ csrf_field() }}
        <input type="hidden" value="{{$oRecipe->id}}" name="id">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Entrez le nom de la recette"
                           value="{{ $oRecipe->name }}" name="sRecipeName"/>
                </div>
            </div>
            <a href="#" class="hidden_delete">X</a>
        </div>

        <!-- utilier le boolean pour afficher la portion une vue ou l'aoRecipe utre -->

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" id="name"  class="form-control produit" placeholder="Entrez un produit"
                           value=" {{ $aProduct[0][0]->name }}" name="aProductName[]"/>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <input type="text" value="{{ $oProduct[0]->quantity }}" id="quantity" class="form-control" name="aQuantity[]" placeholder="Quantité">
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <select class="form-control" id="unit" name="aUnit[]">
                        @foreach($aUnitSelect as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
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