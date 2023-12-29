<?php

namespace App\Http\Controllers;

class SeuSystemController extends Controller
{
    public function index($id = null) {
        if(!isset($id)) {
            return view('SeuSystem.index');
        } else {
            return view('SeuSystem.p'.$id);
        }
    }

    public function home() {
        return view('SeuSystem.home');
    }
}
