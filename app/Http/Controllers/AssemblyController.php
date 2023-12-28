<?php

namespace App\Http\Controllers;

use App\Models\Assembly;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AssemblyController extends Controller
{
    public function index()
    {
        $year = (int)date('Y') - ((int)date('Y') % 4);

        return view ('List.Assembly.list', [
            'assembly' => null,
            'assemblymen' => null,
            'year' => $year
        ]);
    }

    public function show($year, $number, $city_id) {
        $assemblymen = Election
            ::where('year', $year)
            ->where('number', $number)
            ->where('city_id', $city_id)
            ->select(DB::raw('*, sum(votes) as total_votes'))
            ->get()
            ->first();

        return view('Details.Assembly.details', [
            'assemblymen' => $assemblymen
        ]);
    }

    public function filter(Request $request) {
        $query = Assembly::orderBy('state_id', 'ASC');

        if($request->city !== '0') {
            $query = $query->where('city_id', $request->city);
        }

        if($request->state !== '0') {
            $query = $query->where('state_id', $request->state);
        }

        $assembly = $query->get()->first();

        $year = (int)date('Y') - ((int)date('Y') % 4);

        $assemblymen = Election
            ::where('year', $year)
            ->where('city_id', $request->city)
            ->where('job', 'Vereador')
            ->where('elected', true)
            ->groupBy('name')
            ->select(DB::raw('*, sum(votes) as total_votes'));

        if($request->input('sort') === null) {
            $assemblymen = $assemblymen
                ->orderBy('name', 'ASC')
                ->paginate(20);
        } else {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $assemblymen = $assemblymen
                ->orderBy($sortColumn, $sortDirection)
                ->paginate(20);
        }

        $president = Arr::first($assemblymen, function ($value, $key) use ($assembly) {
            return $value->id === $assembly->president_id;
        });

        return view('List.Assembly.list', [
            'assembly' => $assembly,
            'assemblymen' => $assemblymen,
            'president' => $president,
            'year' => $year,
            'filters' => $request->all()
        ]);
    }
}











