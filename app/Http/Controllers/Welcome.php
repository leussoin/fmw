<?php
/**
 * Created by PhpStorm.
 * User: Fixe
 * Date: 23/02/2019
 * Time: 12:42
 */

namespace App\Http\Controllers;


use App\Menu;
use App\Misc;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Session;

class welcome extends Controller {
    /**
     * Manage get welcome page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function welcome() {
        Misc::isAuth();
        //Misc::fmwLogSystem();


        $oUser = session('oUser');

        //TODO : à factoriser => traitement de la volonté
        switch ($oUser->will) {
            case 0:
                //echo "Let's gros ! L'apport quotidien conseillé pour un homme est de 2400k cal / jour et de 1800 pour une femme ";
                break;
            case 1:
                //echo "Moins gros";
                break;
            case 2:
                //echo "Encore moins";
                break;
        }

        //TODO : à factoriser => traitement des 7 jours de la semaine (repas depuis le lundi de la semaine en cours)

        $sDate = date('d-m-Y');
        $aPlatUser = $this::getWeeklyRecipe($oUser, $sDate);
        $aSemaine = $this::getDaysOfWeek($sDate);

        session(['sDate' => $sDate]);

        return view('welcome', ['oUser' => $oUser, 'aSemaine' => $aSemaine, 'date' => $sDate, 'aPlatUser' => $aPlatUser]);
    }

    /**
     * Handle post welcome page
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function welcomePost(Request $request) {

        Misc::isAuth();
        $input = $request->all();
        $oUser = session('oUser');
        $sCurrentDate = session('sDate');
        $sNewDate = '';
        $aIdWeekRecipe['midi'] = $input['midi'];
        $aIdWeekRecipe['soir'] = $input['soir'];


        if ($input['button'] === '+') {
            $sNewDate = date('d-m-Y', strtotime($sCurrentDate . ' +7 days'));
        } elseif ($input['button'] === '-') {
            $sNewDate = date('d-m-Y', strtotime($sCurrentDate . ' -7 days'));
        } elseif ($input['button'] === 'save') {


            // parse le tableau pour savoir si mes recettes existent, si oui = ID
            $aIdRecipe = $this::checkRecipeAndGetIdByName($aIdWeekRecipe);

            // TODO: pas bon, penser aux cas ou on à des jours sans repas et recette foireuses ?
            //if ($bErrorMidi === false && $bErrorSoir === false) {

            $mResult = $this::addMenu($aIdRecipe, $input["first-day"], 1, $oUser);
            //}

            $sNewDate = session('sDate');
        }

        $aPlatUser = $this::getWeeklyRecipe($oUser, $sNewDate);

        $aSemaine = $this->getDaysOfWeek($sNewDate);

        session(['sDate' => $sNewDate]);


        return view('welcome', ['oUser' => $oUser, 'date' => $sNewDate, 'aSemaine' => $aSemaine, 'aPlatUser' => $aPlatUser]);

    }

    /**
     * Get the monday's date
     * @param $sDate
     * @return false|string
     */
    public function getFirstMonday($sDate) {
        return date('d-m-Y', strtotime('last monday', strtotime($sDate)));
    }

    /**
     * Get all recipe from the begining of the week
     * @param $oUser
     * @param $sDate
     * @return mixed
     */
    public function getWeeklyRecipe($oUser, $sDate) {
        $aPlatUser = array();
        $aRecipes = array();

        $sMonday = $this::getFirstMonday($sDate);
        // recupération de la liste compléte des recetes table assoc
        for ($i = 1; $i <= 7; $i++) {
            if ($i == 1) {
                $sDate = date('d-m-Y', strtotime($sMonday));
            } else {
                $sDate = date('d-m-Y', strtotime($sDate . ' +1 days'));
            }
            $aPlatUser[$i] = Menu::getMenu($sDate, $oUser->id);
        }
        // récupération des noms des recettes / jour / plat
        for ($i = 1; $i <= 7; $i++) {

            //midi
            if (!empty($aPlatUser[$i][0]->midi)) {
                $oRecipeMidi = \App\Recipe::getRecipeByID($aPlatUser[$i][0]->id_recipe);
                $aRecipes['midi'][$i] = $oRecipeMidi->name;
            }

            // soir = laisser ISSET car soir = 0 (verifier avec empty cause un bug car 0 = not empty)
            if (isset($aPlatUser[$i][1]->midi)) {
                $oRecipeSoir = \App\Recipe::getRecipeByID($aPlatUser[$i][1]->id_recipe);
                $aRecipes['soir'][$i] = $oRecipeSoir->name;
            }
        }

        return $aRecipes;
    }

    /**
     * Get date for create a complete week begining by monday
     * @param $sDate
     * @return array
     * @throws \Exception
     */
    public
    function getDaysOfWeek($sDate) {

        $sFirstDay = date('Y-m-d', strtotime('last monday', strtotime($sDate)));
        $oFirstDay = new \DateTime($sFirstDay);
        $aSemaine = array();
        $iNumJour = 1;
        while ($iNumJour <= 7) {
            if ($iNumJour == 1) {
                $aSemaine[$iNumJour] = $oFirstDay->format('d-m-Y');
            } else {
                $ledemain = $oFirstDay->modify('+1 day');
                $aSemaine[$iNumJour] = $oFirstDay->format('d-m-Y');
            }
            $iNumJour++;
        }
        return $aSemaine;
    }


    /**
     * Check if a recipe exists, and get his ID
     * @param $aInput
     * @return array
     */
    public
    function checkRecipeAndGetIdByName($aInput) {
        $aIdRecipe = array();
        $iCpt = 0;
        foreach ($aInput as $aMidiOuSoir) {
            for ($i = 1; $i <= 7; $i++) {
                $mExists = \App\Recipe::getRecipeIdByName($aMidiOuSoir[$i - 1]);
                if (!$mExists) {
                    if ($iCpt == 0) {
                        $aIdRecipe['midi'][$i] = false;
                    } else {
                        $aIdRecipe['soir'][$i] = false;
                    }
                    $bError = true;
                } else {
                    if ($iCpt == 0) {
                        $aIdRecipe['midi'][$i] = $mExists->id;
                    } else {
                        $aIdRecipe['soir'][$i] = $mExists->id;
                    }
                }
            }
            $iCpt++;
        }
        return $aIdRecipe;

    }

    /**
     * Handle add / update weekly recipe
     * @param $aMenuSemaine
     * @param $sLundi
     * @param $bIsMidi
     * @param $oUser
     * @return bool|string
     */
    public
    function addMenu($aMenuSemaine, $sLundi, $bIsMidi, $oUser) {
        // dd($aMenuSemaine);
        //TODO: gerer les deux semaines en cas d'erreur d'insertion sur une data en particulier
        $iCpt = 0;
        $mResult = '';
        foreach ($aMenuSemaine as $aMenu) {
            foreach ($aMenu as $key => $iIdRecipe) {
                if ($key == 1) {
                    $jour = $sLundi;
                } else {
                    $jour = date('d-m-Y', strtotime($sLundi . '+ ' . ($key - 1) . ' day'));
                }
                if ($iCpt == 0) {
                    $bIsMidi = 1;
                } else {
                    $bIsMidi = 0;
                }

                $mDelResult = Menu::delMenu($jour, $oUser->id, $bIsMidi);
                //si c'est true / false ?
                if ($iIdRecipe) {
                    $mResult = Menu::addMenu($jour, $iIdRecipe, $oUser->id, $bIsMidi, null);

                }
                //si c'est true / false ?
            }
            $iCpt++;
        }
        //var_dump()
        return $mResult;
    }
}
