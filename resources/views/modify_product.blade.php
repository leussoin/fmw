@extends('layouts/master', ['title' => 'produit'])

@section('content')

    <h1>Ajoutez des produits</h1>


    <form method="post">
        {{ csrf_field() }}
        @foreach($aProduct as $sProduct)
            <input type="hidden" value="{{ $sProduct->id }}" name="id">

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <input type="text" class="form-control produit" placeholder="Entrez un produit" value="{{ $sProduct->name }}" name="sName"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <input type="text" class="form-control" name="iCal" value="{{ $sProduct->cal }}" placeholder="Entrez sa valeur calorifique">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <input type="text" class="form-control" name="fPrice" value="{{ $sProduct->price }}" placeholder="Entrez son prix">
                    </div>
                </div>
            </div>
            <div id="container_input"></div>


            <div class="form-group">
                <button type="submit" value="modifier" class="btn btn-primary">Modifier</button>
            </div>
        @endforeach
    </form>
@endsection
