@extends('layouts/master', ['title' => 'produit'])

@section('content')
    <h1>Lister les produits</h1>

    <input type="hidden" id="token" value="{{ csrf_token() }}">


    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Valeur calorifique</th>
            <th scope="col">Prix</th>
        </tr>
        </thead>
        <tbody>
        @foreach($aProduit as $produit)
            <tr id="{{$produit->id}}">

                <td>{{ $produit->id }}</td>
                <td>{{ $produit->name }}</td>
                <td>{{ $produit->cal }}</td>
                <td>{{ $produit->price }}</td>
                <td>
                    <a data-id="{{ $produit->id }}" class="suppr-produit btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-trash"></span> X
                    </a>
                </td>

            </tr>
            </a>

        @endforeach


        </tbody>
    </table>


@endsection