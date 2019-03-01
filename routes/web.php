<?php

Route::get('/menu', 'c_welcome@welcome_get');

Route::get('/produit/lister', 'c_product@list_product');

Route::get('/produit/ajouter', 'c_product@add_product_get');
Route::post('/produit/ajouter', 'c_product@add_product_post');


Route::get('/produit/modifier/{id}', 'c_product@update_product_get');
Route::post('/produit/modifier/{id}', 'c_product@update_product_post');



Route::get('/produit/supprimer/{id}', 'c_product@ajax_delete_product');


Route::get('/recette/lister', 'c_list_recipe@index_get');

Route::get('/recette/ajouter', 'c_add_recipe@add_recipe_get');

