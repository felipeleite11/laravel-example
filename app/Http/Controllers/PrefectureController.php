<?php

namespace App\Http\Controllers;

use App\Models\Prefecture;
use Exception;
use Illuminate\Http\Request;

class PrefectureController extends Controller
{
    public function index(Request $request)
    {
        $prefectures = Prefecture::with([
            'city' => function($q) {
                $q->orderBy('description', 'asc');
            }
        ]);

        if($request->input('sort') !== null) {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $prefectures = $prefectures->orderBy($sortColumn, $sortDirection);
        }

        $prefectures = $prefectures
            ->join('cities', 'cities.id', '=', 'prefectures.city_id')
            ->select('prefectures.*', 'cities.description')
            ->paginate(20);

        return view('List.Prefecture.list', [
            'prefectures' => $prefectures
        ]);
    }

    public function show($id) {
        $prefecture = Prefecture::findOrFail($id);

        return view('Details.Prefecture.details', [
            'prefecture' => $prefecture
        ]);
    }


    public function edit($id)
    {
        $prefecture = Prefecture::findOrFail($id);

        return view('Store.Prefecture.create')->with('prefecture', $prefecture);
    }

    public function update(Request $request, $id)
    {
        try {
            $prefecture = Prefecture::findOrFail($id);

            $prefecture->state_id = $request->state;
            $prefecture->city_id = $request->city;
            $prefecture->birthdate = $request->birthdate;
            $prefecture->address = $request->address;
            $prefecture->neighborhood = $request->neighborhood;
            $prefecture->association = $request->association;
            $prefecture->phone = $request->phone;

            $prefecture->save();

            return redirect()
                ->action([PrefectureController::class, 'index'])
                ->with('notification', [
                    'message' => 'Os dados foram atualizados!',
                    'type' => 'success'
            ]);
        } catch(Exception $e) {
            return redirect()
                ->action(
                    [PrefectureController::class, 'edit'],
                    ['id' => $id])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function filter(Request $request) {
        $query = Prefecture::with([
            'city' => function($q) {
                $q->orderBy('description', 'ASC');
            }
        ]);

        if($request->input('sort') !== null) {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            if($sortColumn !== 'description') {
                $query = $query->orderBy($sortColumn, $sortDirection);
            }
        }

        if(isset($request->start_date) && isset($request->end_date)) {
            $query = $query->whereBetween('prefectures.datetime', [$request->start_date, $request->end_date]);
        }

        if(isset($request->state)) {
            $query = $query->where('prefectures.state_id', $request->state);
        }

        if($request->city !== '0') {
            $query = $query->where('prefectures.city_id', $request->city);
        }

        $prefectures = $query
            ->with('mayor')
            ->join('cities', 'cities.id', '=', 'prefectures.city_id')
            ->select('prefectures.*', 'cities.description')
            ->paginate(20);

        return view('List.Prefecture.list', [
            'prefectures' => $prefectures,
            'filters' => $request->all()
        ]);
    }
}
