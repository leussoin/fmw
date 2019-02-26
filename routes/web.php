<?php

Route::get('/menu', 'c_welcome@welcome_get');

Route::get('/lister_produit', 'c_list_product@index_get');

Route::get('/lister_recette', 'c_list_recipe@index_get');


Route::get('/ajouter_produit', 'c_product@add_product_get');
Route::post('/ajouter_produit', 'c_product@add_product_post');

Route::get('/modifier_produit/{id}', 'c_product@update_product_post');


Route::post('/supprimer_produit/{id}', 'c_product@ajax_delete_product');


Route::get('/ajouter_recette', 'c_add_recipe@add_recipe_get');

