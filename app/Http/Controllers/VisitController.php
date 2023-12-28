<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Visit;
use Exception;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    public function index(Request $request)
    {
        if($request->input('sort') !== null) {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $visits = Visit::orderBy($sortColumn, $sortDirection);
        } else {
            $visits = Visit::orderBy('date', 'DESC');
        }

        $visits = $visits
            ->join('cities', 'cities.id', '=', 'visits.city_id')
            ->select('visits.*', 'cities.description')
            ->paginate(20);

        return view ('List.Visit.list', ['visits' => $visits]);
    }

    public function show($id) {
        $visit = Visit::findOrFail($id);

        return view('Details.Visit.details', [
            'visit' => $visit
        ]);
    }

    public function create()
    {
        return view('Store.Visit.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validation($request);

            if($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            DB::beginTransaction();

            $visit = new Visit;

            $visit->state_id = $request->state;
            $visit->city_id = $request->city;
            $visit->date = $request->date;
            $visit->place = $request->place;
            $visit->observation = $request->observation;

            $visit->save();

            DB::commit();

            return redirect()
                ->action([VisitController::class, 'index'])
                ->with('notification', [
                    'message' => 'Visita cadastrada com sucesso!',
                    'type' => 'success'
                ]);
        } catch(Exception $e) {
            DB::rollback();

            return redirect()
                ->action([VisitController::class, 'create'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $visit = Visit::findOrFail($id);

        return view('Store.Visit.create')->with('visit', $visit);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $visit = Visit::findOrFail($id);

            $visit->state_id = $request->state;
            $visit->city_id = $request->city;
            $visit->place = $request->place;
            $visit->date = $request->date;
            $visit->observation = $request->observation;

            $visit->save();

            DB::commit();

            return redirect()
                ->action([VisitController::class, 'index'])
                ->with('notification', [
                    'message' => 'A visita foi atualizado com sucesso!',
                    'type' => 'success'
            ]);
        } catch(Exception $e) {
            DB::rollback();

            return redirect()
                ->action([VisitController::class, 'edit'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            Visit::findOrFail($id)->delete();

            return redirect()
                ->action([VisitController::class, 'index'])
                ->with('notification', [
                    'message' => 'Visita removida com sucesso!',
                    'type' => 'success'
                ]);

        } catch(Exception $e) {
            return redirect()
                ->action([VisitController::class, 'index'])
                ->withErrors($e->getMessage());
        }
    }

    private function validation(Request $request) {
        $validationRules = [
            'state' => 'required',
            'city' => 'required|integer',
            'place' => 'required',
            'date' => 'required|regex:/^\d{4}-\d{2}-\d{2}$/i',
            'observation' => 'required'
        ];

        $replacements = [
            'observation' => 'relato'
        ];

        $validator = Validator::make(
            $request->all(),
            $validationRules,
            [],
            $replacements
        );

        return $validator;
    }

    public function filter(Request $request)
    {
        if($request->input('sort') === null) {
            $query = Visit::orderBy('visits.date', 'DESC');
        } else {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $query = Visit::orderBy($sortColumn, $sortDirection);
        }

        if(isset($request->start_date) && isset($request->end_date)) {
            $query = $query->whereBetween('visits.date', [$request->start_date, $request->end_date]);
        }

        if(isset($request->state)) {
            $query = $query->where('visits.state_id', $request->state);
        }

        if($request->city !== '0') {
            $query = $query->where('visits.city_id', $request->city);
        }

        $visits = $query
            ->join('cities', 'cities.id', '=', 'visits.city_id')
            ->select('visits.*', 'cities.description')
            ->paginate(20);

        return view ('List.Visit.list', [
            'visits' => $visits,
            'filters' => $request->all()
        ]);
    }
}
