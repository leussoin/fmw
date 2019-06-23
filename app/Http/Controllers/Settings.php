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
class Settings extends Controller
{

    public function index() {
        Misc::isAuth();

        $oUser = session('oUser');
        $aDislikedProduct = \App\Users::getPreferences($oUser->id);

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

        \App\Misc::isAuth();

        $term = $request->all();
        $oUser = session('oUser');
        $aProduct = array_filter(array_unique(explode(';', $term['products'])));
        if ($term['passwd']) {
            $term['passwd'] = hash('sha512', $term['passwd']);
        }
        $oProduct = array();


        $mResult = $this::deleteUserDislikedProduct($oUser->id);

        foreach ($aProduct as $product) {
            $cProduct = Product::getIdProductByName($product);

            $iValidationUpdate = $this::setUserPreferencesProduct($cProduct[0]->id, $oUser->id);
        }
        //Si j'ai un password...
        if ($term['passwd']) {
            $iValidationUpdate = $this::setUserPassword($oUser->id, $term['passwd']);
        }

        if ($term['genre']) {
            $iValidationUpdate = $this::setUserGenre($oUser->id, $term['genre']);
            //TODO : verifier le retour
            session(['genre' => $term['genre']]);
        }

        if ($term['will']) {
            dd($oUser);
            $this::updateUserWill($oUser->id, $term['will']);
            session(['will' => $term['will']]);

        }

        return view('settings', ['oUser' => $oUser, 'aProduct' => $aProduct]);
    }

    /**
     * Manage users disliked product
     * TODO : ajouter les produits qu'on aime bien
     * @param $iIdProduct
     * @param null $iIdUser
     * @return bool
     */
    public function setUserPreferencesProduct($iIdProduct, $iIdUser = null) {
        $mResult = \App\Users::addUserData($iIdUser, $iIdProduct);
        return $mResult;
    }


    /**
     * Update user password
     * @param null $iIdUser
     * @param null $sPassword
     * @return bool
     */
    public function setUserPassword($iIdUser, $sPassword) {
        return \App\Users::updatePassword($iIdUser, $sPassword);
    }

    /**
     * Update user genre
     * @param null $iIdUser
     * @param $sgenre
     * @return bool
     */
    public function setUserGenre($iIdUser, $sgenre) {
        return \App\Users::updateUserGenre($iIdUser, $sgenre);
    }

    /**
     * Delete all removed user disliked products
     * @param null $iIdUser
     * @return bool
     */
    public function deleteUserDislikedProduct($iIdUser) {
        return \App\Users::deleteUserData($iIdUser);
    }

    /**
     * Update user will
     * @param null $iIdUser
     * @return bool
     */
    public function updateUserWill($iIdUser, $iIdwill) {
        return \App\Users::updateUserWill($iIdUser, $iIdwill);
    }


}