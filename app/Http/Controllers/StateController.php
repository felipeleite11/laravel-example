<?php

namespace App\Http\Controllers;

use App\Models\State;

class StateController extends Controller
{
    public function index()
    {
        $states = State::orderBy('description', 'ASC')->get();

        return json_decode($states, true);
    }

    public function byName($name) {
        $state = State::where('description', $name)->firstOrFail();

        return json_decode($state, true);
    }

    public function byInitials($initias) {
        $state = State::where('initials', $initias)->firstOrFail();

        return json_decode($state, true);
    }
}
