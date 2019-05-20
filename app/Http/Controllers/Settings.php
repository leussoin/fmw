<?php
/**
 * Created by PhpStorm.
 * User: Fixe
 * Date: 23/02/2019
 * Time: 13:49
 */

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

/**
 * Handle all that refers to users settings
 * @package App\Http\Controllers
 */
class Settings extends Controller {

    public function index() {

        $oUser = session('oUser');
        return view('settings', ['oUser' => $oUser]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $term = $request->all();

        dd($term);
    }




    }