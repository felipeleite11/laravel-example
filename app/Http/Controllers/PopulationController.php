<?php

namespace App\Http\Controllers;

use App\Models\Population;
use Illuminate\Http\Request;

class PopulationController extends Controller
{
    public function index(Request $request)
    {
        if($request->input('sort') !== null) {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $populations = Population::orderBy($sortColumn, $sortDirection)->paginate(20);
        } else {
            $populations = Population::orderBy('year', 'DESC')->paginate(20);
        }

        return view('List.Population.list', [
            'populations' => $populations
        ]);
    }

    public function show($id) {
        $population = Population::findOrFail($id);

        return view('Details.Population.details', [
            'population' => $population
        ]);
    }

}
