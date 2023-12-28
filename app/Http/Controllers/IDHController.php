<?php

namespace App\Http\Controllers;

use App\Models\IDH;
use Illuminate\Http\Request;

class IDHController extends Controller
{
    public function list(Request $request)
    {
        if($request->input('sort') !== null) {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $idh = IDH::orderBy($sortColumn, $sortDirection);
        } else {
            $idh = IDH::orderBy('id', 'asc');
        }

        $idh = $idh
            ->join('cities', 'cities.id', '=', 'idh.city_id')
            ->select('idh.*', 'cities.description')
            ->paginate(20);

        return view('List.IDH.list', [
            'idhs' => $idh
        ]);
    }

    public function show($city_id, $year) {
        $idh = IDH::
            where('year', $year)
            ->where('city_id', $city_id)
            ->get()
            ->first();

        return view('Details.IDH.details', [
            'idh' => $idh
        ]);
    }

    public function filter(Request $request) {
        if($request->input('sort') === null) {
            $query = IDH::
                orderBy('idh.state_id', 'ASC')
                ->orderBy('idh.city_id', 'ASC');
        } else {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $query = IDH::orderBy($sortColumn, $sortDirection);
        }

        if($request->city !== '0') {
            $query = $query->where('idh.city_id', $request->city);
        }

        if($request->state !== '0') {
            $query = $query->where('idh.state_id', $request->state);
        }

        if($request->year !== '0') {
            $query = $query->where('idh.year', $request->year);
        }

        $idhs = $query
            ->join('cities', 'cities.id', '=', 'idh.city_id')
            ->select('idh.*', 'cities.description')
            ->paginate(20);

        return view('List.IDH.list', [
            'idhs' => $idhs,
            'filters' => $request->all()
        ]);
    }
}
