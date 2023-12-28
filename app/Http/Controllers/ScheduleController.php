<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Schedule;
use Exception;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        if($request->input('sort') !== null) {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $schedules = Schedule::orderBy($sortColumn, $sortDirection);
        } else {
            $schedules = Schedule::orderBy('datetime', 'DESC');
        }

        $schedules = $schedules
            ->join('cities', 'cities.id', '=', 'schedules.city_id')
            ->select('schedules.*', 'cities.description')
            ->paginate(20);

        return view ('List.Schedule.list', ['schedules' => $schedules]);
    }

    public function show($id) {
        $schedule = Schedule::findOrFail($id);

        return view('Details.Schedule.details', [
            'schedule' => $schedule
        ]);
    }

    public function create()
    {
        return view('Store.Schedule.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validation($request);

            if($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            DB::beginTransaction();

            $schedule = new Schedule;

            $schedule->state_id = $request->state;
            $schedule->city_id = $request->city;
            $schedule->event = $request->event;
            $schedule->address = $request->address;
            $schedule->datetime = $request->date.' '.$request->time;
            $schedule->observation = $request->observation;

            $schedule->save();

            DB::commit();

            return redirect()
                ->action([ScheduleController::class, 'index'])
                ->with('notification', [
                    'message' => 'Compromisso cadastrado com sucesso!',
                    'type' => 'success'
                ]);
        } catch(Exception $e) {
            DB::rollback();

            return redirect()
                ->action([ScheduleController::class, 'create'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $schedule = Schedule::findOrFail($id);

            return view('Store.Schedule.create', ['schedule' => $schedule]);

        } catch(Exception $e) {
            return redirect()
                ->action([ScheduleController::class, 'edit'])
                ->withErrors('Erro ao carregar os dados do compromisso.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $schedule = Schedule::findOrFail($id);

            $schedule->state_id = $request->state;
            $schedule->city_id = $request->city;
            $schedule->event = $request->event;
            $schedule->address = $request->address;
            $schedule->datetime = $request->date.' '.$request->time;
            $schedule->observation = $request->observation;

            $schedule->save();

            DB::commit();

            return redirect()
                ->action([ScheduleController::class, 'index'])
                ->with('notification', [
                    'message' => 'Compromisso atualizado com sucesso!',
                    'type' => 'success'
                ]);
        } catch(Exception $e) {
            DB::rollback();

            return redirect()
                ->action([ScheduleController::class, 'edit'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            Schedule::findOrFail($id)->delete();

            return redirect()
                ->action([ScheduleController::class, 'index'])
                ->with('notification', [
                    'message' => 'Compromisso removido com sucesso!',
                    'type' => 'success'
                ]);
        } catch(Exception $e) {
            return redirect()
                ->action([ScheduleController::class, 'index'])
                ->withErrors($e->getMessage());
        }
    }

    private function validation(Request $request) {
        $validationRules = [
            'state' => 'required',
            'city' => 'required|integer',
            'address' => 'required',
            'date' => 'required|regex:/^\d{4}-\d{2}-\d{2}$/i',
            'time' => 'required|regex:/^\d{2}\:\d{2}$/i'
        ];

        $validator = Validator::make($request->all(), $validationRules);

        return $validator;
    }

    public function filter(Request $request)
    {
        if($request->input('sort') === null) {
            $query = Schedule::orderBy('schedules.datetime', 'DESC');
        } else {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $query = Schedule::orderBy($sortColumn, $sortDirection);
        }

        if(isset($request->start_date) && isset($request->end_date)) {
            $query = $query->whereBetween('schedules.datetime', [$request->start_date, $request->end_date]);
        }

        if(isset($request->state)) {
            $query = $query->where('schedules.state_id', $request->state);
        }

        if($request->city !== '0') {
            $query = $query->where('schedules.city_id', $request->city);
        }

        $schedules = $query
            ->join('cities', 'cities.id', '=', 'schedules.city_id')
            ->select('schedules.*', 'cities.description')
            ->paginate(20);

        return view('List.Schedule.list', [
            'schedules' => $schedules,
            'filters' => $request->all()
        ]);
    }
}
