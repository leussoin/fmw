<?php

Route::get('/menu', 'Welcome@welcome');


// Produits

Route::get('/produit/lister', 'Product@productList');

Route::get('/produit/ajouter', 'Product@productAddGet');
Route::post('/produit/ajouter', 'Product@productAddPost');

Route::get('/produit/modifier/{id}', 'Product@updateProductGet');
Route::post('/produit/modifier/{id}', 'Product@updateProductPost');

Route::get('/produit/autocomplete', 'Product@getProductByPartialName');
Route::post('/produit/supprimer/{id}', 'Product@deleteProductAjaxPost');


//Recettes
Route::get('/recette/lister', 'Recipe@recipeList');

Route::get('/recette/ajouter', 'Recipe@addRecipeGet');
Route::post('/recette/ajouter', 'Recipe@addRecipePost');

Route::post('/recette/supprimer/{id}', 'Recipe@deleteRecipeAjaxPost');




Route::resource('/settings', 'Settings');


//Route::resource('/recette', 'Recipe');


Route::get('/toto','AdminController@index');
Route::get('/display/{term}','AdminController@searchData');

