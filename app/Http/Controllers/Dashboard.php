<?php


namespace App\Http\Controllers;


class Dashboard extends Controller {

    public function indexGet() {
        return view('dashboard');
    }
}

