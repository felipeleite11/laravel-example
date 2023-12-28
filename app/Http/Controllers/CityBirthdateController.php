<?php

namespace App\Http\Controllers;

use App\Models\Prefecture;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CityBirthdateController extends Controller
{
    public function index(Request $request)
    {
        if($request->input('sort') !== null) {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $prefecture = Prefecture::orderBy($sortColumn, $sortDirection);
        } else {
            $prefecture = Prefecture::orderBy('id', 'asc');
        }

        $prefecture = $prefecture
            ->join('cities', 'cities.id', '=', 'prefectures.city_id')
            ->select('prefectures.*', 'cities.description')
            ->paginate(20);

        return view('List.CityBirthdate.list', [
            'prefectures' => $prefecture
        ]);


        $prefectures = Prefecture::get();

        return view('List.CityBirthdate.list', [
            'prefectures' => $prefectures
        ]);
    }

    public function create()
    {
        return view('Store.CityBirthdate.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validation($request);

            if($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            DB::beginTransaction();

            $prefecture = new Prefecture();

            $prefecture->state_id = $request->state;
            $prefecture->city_id = $request->city;
            $prefecture->date = $request->birthdate;

            $prefecture->save();

            DB::commit();

            return redirect()
                ->action([CityBirthdateController::class, 'index'])
                ->with('notification', [
                    'message' => 'Aniversário cadastrado com sucesso!',
                    'type' => 'success'
            ]);

        } catch(Exception $e) {
            DB::rollback();

            return redirect()
                ->action([CityBirthdateController::class, 'create'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $prefecture = Prefecture::findOrFail($id);

        return view('Store.CityBirthdate.create', [
            'prefecture' => $prefecture
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $prefecture = Prefecture::findOrFail($id);

            $prefecture->state_id = $request->state;
            $prefecture->city_id = $request->city;
            $prefecture->date = $request->date;

            $prefecture->save();

            DB::commit();

            return redirect()
                ->action([CityBirthdateController::class, 'index'])
                ->with('notification', [
                    'message' => 'Aniversário atualizado com sucesso!',
                    'type' => 'success'
                ]);

        } catch(Exception $e) {
            return redirect()
                ->action([CityBirthdateController::class, 'edit'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            Prefecture::findOrFail($id)->delete();

            return redirect()
                ->action([CityBirthdateController::class, 'index'])
                ->with('notification', [
                    'message' => 'Aniversário removido com sucesso!',
                    'type' => 'success'
                ]);

        } catch(Exception $e) {
            return redirect()
                ->action([VisitController::class, 'index'])
                ->withErrors($e->getMessage());
        }
    }

    public function filter(Request $request)
    {
        $prefectures = $this->filterApply($request);

        return view ('List.CityBirthdate.list', [
            'prefectures' => $prefectures
        ]);
    }

    private function filterApply(Request $request) {
        if($request->input('sort') === null) {
            $query = Prefecture::
                orderBy('prefectures.state_id', 'ASC')
                ->orderBy('prefectures.city_id', 'ASC');
        } else {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $query = Prefecture::orderBy($sortColumn, $sortDirection);
        }

        if($request->state !== '0') {
            $query = $query->where('prefectures.state_id', $request->state);
        }

        if($request->month !== '0') {
            $query = $query->whereMonth('prefectures.birthdate', $request->month);
        }

        $prefectures = $query
            ->join('cities', 'cities.id', '=', 'prefectures.city_id')
            ->select('prefectures.*', 'cities.description')
            ->paginate(20);

        return $prefectures;
    }

    private function validation(Request $request) {
        $validationRules = [
            'state' => 'required',
            'birthdate' => 'regex:/^\d{4}-\d{2}-\d{2}$/i'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        return $validator;
    }
}
