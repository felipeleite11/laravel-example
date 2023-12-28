<?php

namespace App\Http\Controllers;

class HotelController extends Controller
{
    public function hotels()
    {
        return view('Hotel.index');
    }
}
