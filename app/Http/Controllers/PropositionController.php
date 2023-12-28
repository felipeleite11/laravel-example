<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Proposition;
use App\Models\PropositionSituation;
use App\Models\PropositionType;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PropositionController extends Controller
{
    public function index(Request $request)
    {
        if($request->input('sort') !== null) {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $propositions = Proposition::orderBy($sortColumn, $sortDirection);
        } else {
            $propositions = Proposition::orderBy('date', 'DESC');
        }

        $propositions = $propositions
            ->join('cities', 'cities.id', '=', 'propositions.city_id')
            ->select('propositions.*', 'cities.description')
            ->paginate(20);

        $types = PropositionType::orderBy('description', 'ASC')->get();
        $situations = PropositionSituation::orderBy('description', 'ASC')->get();

        return view('List.Proposition.list', [
            'propositions' => $propositions,
            'types' => $types,
            'situations' => $situations
        ]);
    }

    public function show($id) {
        $proposition = Proposition::findOrFail($id);

        return view('Details.Proposition.details', [
            'proposition' => $proposition
        ]);
    }

    public function create()
    {
        return view('Store.Proposition.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validation($request);

            if($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            DB::beginTransaction();

            $proposition = new Proposition;

            $proposition->state_id = $request->state;
            $proposition->city_id = $request->city;
            $proposition->type_id = $request->type;
            $proposition->number = $request->number;
            $proposition->year = $request->year;
            $proposition->date = $request->date;
            $proposition->description = $request->description;
            $proposition->observation = $request->observation;
            $proposition->reference = $request->reference;
            $proposition->area = $request->area;
            $proposition->situation_id = $request->situation;

            if($request->has('document')) {
                $path = $request->file('document')->store('public');

                $filename = Arr::last(explode('/', $path), function($v) { return $v; });

                $proposition->file = $filename;
            }

            $proposition->save();

            DB::commit();

            return redirect()
                ->action([PropositionController::class, 'index'])
                ->with('notification', [
                    'message' => 'Proposição cadastrada com sucesso!',
                    'type' => 'success'
                ]);
        } catch(Exception $e) {
            DB::rollback();

            return redirect()
                ->action([PropositionController::class, 'create'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $proposition = Proposition::findOrFail($id);

        return view('Store.Proposition.create')->with('proposition', $proposition);
    }

    public function update(Request $request, $id)
    {
        try {
            $proposition = Proposition::findOrFail($id);

            $proposition->state_id = $request->state;
            $proposition->city_id = $request->city;
            $proposition->type_id = $request->type;
            $proposition->number = $request->number;
            $proposition->year = $request->year;
            $proposition->date = $request->date;
            $proposition->description = $request->description;
            $proposition->observation = $request->observation;
            $proposition->reference = $request->reference;
            $proposition->area = $request->area;
            $proposition->situation_id = $request->situation;

            $proposition->save();

            return redirect()
                ->action([PropositionController::class, 'index'])
                ->with('notification', [
                    'message' => 'A proposição foi atualizada com sucesso!',
                    'type' => 'success'
            ]);
        } catch(Exception $e) {
            return redirect()
                ->action([PropositionController::class, 'edit'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $proposition = Proposition::findOrFail($id);

            $proposition->delete();

            return redirect()
                ->action([PropositionController::class, 'index'])
                ->with('notification', [
                    'message' => 'Proposição nº '.$proposition->number.' removida com sucesso!',
                    'type' => 'success'
                ]);

        } catch(Exception $e) {
            return redirect()
                ->action([PropositionController::class, 'index'])
                ->withErrors($e->getMessage());
        }
    }

    private function validation(Request $request) {
        $validationRules = [
            'state' => 'required',
            'city' => 'required',
            'type' => 'required',
            'number' => 'required',
            'year' => 'required|size:4',
            'date' => 'required|regex:/^\d{4}-\d{2}-\d{2}$/i',
            'description' => 'required|max:100',
            'situation' => 'required',
            'document' => 'file|max:2000'
        ];

        $replacements = [
            'situation' => 'situação'
        ];

        $sentences = [
            'document.max' => 'O arquivo anexado não deve exceder 2MB.',
        ];

        $validator = Validator::make($request->all(), $validationRules, $sentences, $replacements);

        return $validator;
    }

    public function filter(Request $request)
    {
        $propositions = $this->filterApply($request);

        $types = PropositionType::orderBy('description', 'ASC')->get();
        $situations = PropositionSituation::orderBy('description', 'ASC')->get();

        return view('List.Proposition.list', [
            'propositions' => $propositions,
            'types' => $types,
            'situations' => $situations,
            'filters' => $request->all()
        ]);
    }

    private function filterApply(Request $request) {
        if($request->input('sort') === null) {
            $query = Proposition::orderBy('propositions.date', 'DESC');
        } else {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $query = Proposition::orderBy($sortColumn, $sortDirection);
        }

        if(isset($request->start_date) && isset($request->end_date)) {
            $propositions = $query->whereBetween('propositions.date', [$request->start_date, $request->end_date]);
        }

        if(isset($request->year)) {
            $query = $query->where('propositions.year', $request->year);
        }

        if(isset($request->number)) {
            $query = $query->where('propositions.number', $request->number);
        }

        if(isset($request->situation)) {
            $query = $query->where('propositions.situation_id', $request->situation);
        }

        if(isset($request->type)) {
            $query = $query->where('propositions.type_id', $request->type);
        }

        if($request->state !== '0') {
            $query = $query->where('propositions.state_id', $request->state);
        }

        if($request->city !== '0') {
            $query = $query->where('propositions.city_id', $request->city);
        }

        $propositions = $query
            ->join('cities', 'cities.id', '=', 'propositions.city_id')
            ->select('propositions.*', 'cities.description')
            ->paginate(20);

        return $propositions;
    }
}
