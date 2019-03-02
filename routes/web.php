<?php

Route::get('/menu', 'Welcome@welcome');

Route::get('/produit/lister', 'Product@productList');

Route::get('/produit/ajouter', 'Product@productAddGet');
Route::post('/produit/ajouter', 'Product@productAddPost');


Route::get('/produit/modifier/{id}', 'Product@updateProductGet');
Route::post('/produit/modifier/{id}', 'Product@updateProductPost');

Route::post('/produit/supprimer/{id}', 'Product@deleteProductAjaxPost');

Route::get('/recette/lister', 'Recipe@recipeList');

Route::get('/recette/ajouter', 'Recipe@addRecipeGet');
Route::post('/recette/ajouter', 'Recipe@addRecipePost');


Route::resource('/settings', 'Settings');


//Route::resource('/recette', 'Recipe');


