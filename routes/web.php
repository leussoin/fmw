<?php

Route::get('/menu', 'Welcome@welcome');
Route::post('/menu', 'Welcome@welcomePost');

Route::get('/recette/autocomplete', 'Recipe@getRecipeByPartialName');

Route::get('/recette/getCalorie', 'Recipe@getCalWithRecipeNameGet');

Route::get('/', 'Login@getLogin');
Route::post('/', 'Login@postLogin');

Route::get('/liste-course', 'Shopping@shoppingListGet');



// ----------- Produits

Route::get('/produit/lister', 'Product@productList');

Route::get('/produit/ajouter', 'Product@productAddGet');
Route::post('/produit/ajouter', 'Product@productAddPost');

Route::get('/produit/modifier/{id}', 'Product@updateProductGet');
Route::post('/produit/modifier/{id}', 'Product@updateProductPost');

Route::get('/produit/autocomplete', 'Product@getProductByPartialName');
Route::post('/produit/supprimer/{id}', 'Product@deleteProductAjaxPost');


// -------------- Recettes

Route::get('/recette/lister', 'Recipe@recipeListGet');
Route::post('/recette/lister', 'Recipe@recipeListPost');

Route::get('/recette/ajouter', 'Recipe@addRecipeGet');
Route::post('/recette/ajouter', 'Recipe@addRecipePost');

Route::get('/recette/modifier/{id}', 'Recipe@updateRecipeGet');
Route::post('/recette/modifier/{id}', 'Recipe@updateRecipePost');

Route::get('/parametres', 'Settings@index');
Route::post('/parametres', 'Settings@store');

Route::post('/recette/supprimer/{id}', 'Recipe@deleteRecipeAjaxPost');




// -------------- Restes
Route::get('/restes', 'Restes@welcomeGet');
Route::post('/restes', 'Restes@welcomePost');



// -------------- Ajax recette
Route::get('/recette/getUnitAjax', 'Recipe@getUnitAjax');

// utiliser cette route pour générer un PDF
Route::get('/generate-pdf','HomeController@generatePDF');


Route::get('/dashboard', 'Dashboard@indexGet');

//Route::resource('/recette', 'Recipe');
//Route::get('/toto','AdminController@index');
//Route::get('/display/{term}','AdminController@searchData');

