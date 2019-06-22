<?php
/**
 * Created by PhpStorm.
 * User: Fixe
 * Date: 23/02/2019
 * Time: 13:49
 */

namespace App\Http\Controllers;

use App\Misc;
use App\Product;
use App\Users;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Handle all that refers to users settings
 * @package App\Http\Controllers
 */
class Settings extends Controller {

    public function index() {
        Misc::isAuth();

        $oUser = session('oUser');
        $aDislikedProduct = Users::getDislikedProduct($oUser->id);

        $aProduct = array();
        if (!empty($aDislikedProduct)) {
            foreach ($aDislikedProduct as $oDislikedProduct) {
                $oProduct = Product::getProductById($oDislikedProduct->product_disliked);
                $aProduct[] = $oProduct[0]->name;
            }
        }
        return view('settings', ['oUser' => $oUser, 'aProduct' => $aProduct]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request) {
        App\Misc::isAuth();

        $term = $request->all();
        $oUser = session('oUser');
        $aProduct = array_filter(array_unique(explode(';', $term['products'])));
        $term['passwd'] = hash('sha512', $term['passwd']);
        // update le paramétrages des utilisateurs
        $iValidationUpdate = users::setUserParams($term, $oUser->id);
        $oProduct = array();

        //TODO: faire le systéme d'erreur d'affichage de messages d'erreur
        if ($iValidationUpdate === 1) {
            echo 'Les modifications seront toutes effectives lors de votre prochaine connexion.';
        } else {
            echo 'Erreur sur update settings utilisateur';
        }

        //suppression de tous les enregistrement where id user
        //Users::deleteDislikedProduct($oUser->id);

        // je récupére les produits
        $aDislikedProduct = Users::getDislikedProduct($oUser->id);
        foreach ($aDislikedProduct as $oItem) {
            $oProduct = Product::getProductById($oItem->product_disliked);
        }

        //Je reinsére les datas
        foreach ($aProduct as $product) {
            $cProduct = Product::getIdProductByName($product);
            //dd($iIdProduct[0]->id);
            //TODO: checker le retour pour verifier les erreurs
            //si le couple ID du produit + id utilisateur existe en base je ne l'insére pas
            $bExistingData = users::getAssocProduct($oUser->id, $cProduct[0]->id);

            if (!$bExistingData) {
                $mData = Users::setDislikedProduct($oUser->id, $cProduct[0]->id);
                //if ($mData) {//do something}
            } else {
                //var_dump("y'a déjà");
            }
        }

        return view('settings', ['oUser' => $oUser, 'aProduct' => $aProduct]);
    }


}