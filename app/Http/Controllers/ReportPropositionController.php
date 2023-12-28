<?php

namespace App\Http\Controllers;

use App\Models\Proposition;
use Illuminate\Http\Request;

class ReportPropositionController extends Controller
{
    public function index()
    {
        $propositions = Proposition::orderBy('date', 'DESC')->get();

        return view('Report.Proposition.list', [
            'propositions' => $propositions
        ]);
    }

    public function filter(Request $request)
    {
        $query = Proposition::orderBy('date', 'ASC');

        if($request->year !== '0') {
            $query = $query->whereYear('date', $request->year);
        }

        $propositions = $query->get();

        return view('Report.Proposition.list', [
            'searched_year' => $request->year,
            'propositions' => $propositions
        ]);
    }
}
