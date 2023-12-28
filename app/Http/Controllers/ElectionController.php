<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class ElectionController extends Controller
{
    public function index()
    {
        return view('List.Election.list', [
            'election' => []
        ]);
    }

    public function show($id) {
        $election = Election::findOrFail($id);

        return view('Details.Election.details', [
            'election' => $election
        ]);
    }

    public function filter(Request $request) {
        try {
            $this->filterValidation($request);

            $election = $this->filterApply($request);

            return view('List.Election.list', [
                'election' => $election,
                'filters' => $request->all()
            ]);
        } catch(Exception $e) {
            return redirect()
                ->action([ElectionController::class, 'index'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    private function filterValidation(Request $request) {
        if($request->year === '0') {
            throw new Exception('Selecione um ano para a pesquisa.');
        }

        if($request->city === '0') {
            throw new Exception('Selecione um cidade para a pesquisa.');
        }
    }

    private function filterApply(Request $request) {
        if($request->input('sort') === null) {
            $query = Election::
                orderBy('year', 'ASC')
                ->orderBy('round', 'ASC')
                ->orderBy('votes', 'DESC')
                ->groupBy('number')
                ->groupBy('round');
        } else {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $query = Election::
                orderBy($sortColumn, $sortDirection)
                ->groupBy('number')
                ->groupBy('round');
        }

        if($request->year !== '0') {
            $query = $query->where('year', $request->year);
        }

        if($request->job !== '0') {
            $query = $query->where('job', $request->job);
        }

        if($request->city !== '0') {
            $query = $query->where('city_id', $request->city);
        }

        if($request->state !== '0') {
            $query = $query->where('state_id', $request->state);
        }

        if($request->elected_only === 'on') {
            $query = $query->where('elected', 1);
        }

        $election = $query
            ->select(DB::raw('*, sum(votes) as round_votes'))
            ->sortable()
            ->paginate(20);

        return $election;
    }
}
