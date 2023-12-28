<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Exception;

class EducationController extends Controller
{
    public function index()
    {
        return view('List.Education.list', [
            'education' => null
        ]);
    }

    private function filterValidation(Request $request) {
        if($request->year === '0') {
            throw new Exception('Selecione um ano para a pesquisa.');
        }

        if($request->state === '0') {
            throw new Exception('Selecione um estado para a pesquisa.');
        }
    }

    public function filter(Request $request) {
        try {
            $this->filterValidation($request);

            $education = $this->filterApply($request);

            return view('List.Education.list', [
                'education' => $education,
                'filters' => $request->all()
            ]);
        } catch(Exception $e) {
            return redirect()
                ->action([ElectionController::class, 'index'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    private function filterApply(Request $request) {
        if($request->input('sort') === null) {
            $query = Education::orderBy('education.city_id', 'ASC');
        } else {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $query = Education::orderBy($sortColumn, $sortDirection);
        }

        if($request->year !== '0') {
            $query = $query->where('education.year', $request->year);
        }

        if($request->city !== '0') {
            $query = $query->where('education.city_id', $request->city);
        }

        if($request->state !== '0') {
            $query = $query->where('education.state_id', $request->state);
        }

        $education = $query
            ->join('cities', 'cities.id', '=', 'education.city_id')
            ->select('education.*', 'cities.description')
            ->paginate(20);

        return $education;
    }
}
