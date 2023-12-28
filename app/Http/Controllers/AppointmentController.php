<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\AppointmentAdministration;
use App\Models\AppointmentSituation;
use App\Models\AppointmentType;
use App\Models\City;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PDF;

class AppointmentController extends Controller
{
    public function index(Request $request) {
        if($request->input('sort') !== null) {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $appointments = Appointment::orderBy($sortColumn, $sortDirection);
        } else {
            $appointments = Appointment::orderBy('date', 'DESC');
        }

        $appointments = $appointments
            ->join('cities', 'cities.id', '=', 'appointments.city_id')
            ->select('appointments.*', 'cities.description')
            ->paginate(20);

        $administrations = AppointmentAdministration::orderBy('description', 'ASC')->get();
        $types = AppointmentType::orderBy('description', 'ASC')->get();
        $situations = AppointmentSituation::orderBy('description', 'ASC')->get();

        return view('List.Appointment.list', [
            'appointments' => $appointments,
            'administrations' => $administrations,
            'types' => $types,
            'situations' => $situations
        ]);
    }

    public function show($id) {
        $appointment = Appointment::findOrFail($id);

        return view('Details.Appointment.details', [
            'appointment' => $appointment
        ]);
    }

    public function create() {
        $administrations = AppointmentAdministration::orderBy('description', 'ASC')->get();
        $types = AppointmentType::orderBy('description', 'ASC')->get();
        $situations = AppointmentSituation::orderBy('description', 'ASC')->get();

        return view('Store.Appointment.create', [
            'administrations' => $administrations,
            'types' => $types,
            'situations' => $situations
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validation($request);

            if($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            DB::beginTransaction();

            $appointment = new Appointment;

            $appointment->state_id = $request->state;
            $appointment->city_id = $request->city;
            $appointment->administration_id = $request->administration;
            $appointment->type_id = $request->type;
            $appointment->date = $request->date;
            $appointment->name = $request->name;
            $appointment->phone = $request->phone;
            $appointment->observation = $request->observation;
            $appointment->reference = $request->reference;
            $appointment->responsible = $request->responsible;
            $appointment->situation_id = $request->situation;

            $appointment->save();

            DB::commit();

            return redirect()
                ->action([AppointmentController::class, 'index'])
                ->with('notification', [
                    'message' => 'Atendimento cadastrado com sucesso!',
                    'type' => 'success'
                ]);
        } catch(Exception $e) {
            return redirect()
                ->action([AppointmentController::class, 'create'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $administrations = AppointmentAdministration::orderBy('description', 'ASC')->get();
        $types = AppointmentType::orderBy('description', 'ASC')->get();
        $situations = AppointmentSituation::orderBy('description', 'ASC')->get();

        return view('Store.Appointment.create', [
            'appointment' => $appointment,
            'administrations' => $administrations,
            'types' => $types,
            'situations' => $situations
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $appointment = Appointment::findOrFail($id);

            $appointment->state_id = $request->state;
            $appointment->city_id = $request->city;
            $appointment->administration_id = $request->administration;
            $appointment->type_id = $request->type;
            $appointment->date = $request->date;
            $appointment->name = $request->name;
            $appointment->phone = $request->phone;
            $appointment->observation = $request->observation;
            $appointment->reference = $request->reference;
            $appointment->responsible = $request->responsible;
            $appointment->situation_id = $request->situation;

            $appointment->save();

            DB::commit();

            return redirect()
                ->action([AppointmentController::class, 'index'])
                ->with('notification', [
                    'message' => 'Atendimento atualizado com sucesso!',
                    'type' => 'success'
                ]);

        } catch(Exception $e) {
            return redirect()
                ->action([AppointmentController::class, 'edit'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            Appointment::findOrFail($id)->delete();

            return redirect()
                ->action([AppointmentController::class, 'index'])
                ->with('notification', [
                    'message' => 'Atendimento cancelado com sucesso!',
                    'type' => 'success'
                ]);

        } catch(Exception $e) {
            return redirect()
                ->action([AppointmentController::class, 'index'])
                ->withErrors($e->getMessage());
        }
    }

    private function validation(Request $request) {
        $validationRules = [
            'state' => 'required',
            'city' => 'required',
            'administration' => 'required',
            'type' => 'required',
            'name' => 'required',
            'date' => 'required|regex:/^\d{4}-\d{2}-\d{2}$/i',
            'phone' => 'required|regex:/^\(\d{2}\) \d{5}-\d{4}$/i',
            'observation' => 'required',
            'reference' => 'required',
            'responsible' => 'required',
            'situation' => 'required'
        ];

        $replacements = [
            'administration' => 'administração do atendimento',
            'type' => 'tipo de atendimento',
            'reference' => 'referência',
            'responsible' => 'observação',
            'situation' => 'situação'
        ];

        $validator = Validator::make($request->all(), $validationRules, [], $replacements);

        return $validator;
    }

    public function filter(Request $request)
    {
        $appointments = $this->filterApply($request);

        $administrations = AppointmentAdministration::orderBy('description', 'ASC')->get();
        $types = AppointmentType::orderBy('description', 'ASC')->get();
        $situations = AppointmentSituation::orderBy('description', 'ASC')->get();

        return view ('List.Appointment.list', [
            'appointments' => $appointments,
            'administrations' => $administrations,
            'types' => $types,
            'situations' => $situations,
            'filters' => $request->all()
        ]);
    }

    private function filterApply(Request $request) {
        if($request->input('sort') === null) {
            $query = Appointment::orderBy('appointments.date', 'DESC');
        } else {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $query = Appointment::orderBy($sortColumn, $sortDirection);
        }

        if(isset($request->type)) {
            $query = $query->where('appointments.type_id', $request->type);
        }

        if(isset($request->situation)) {
            $query = $query->where('appointments.situation_id', $request->situation);
        }

        if(isset($request->administration)) {
            $query = $query->where('appointments.administration_id', $request->administration);
        }

        if(isset($request->start_date) && isset($request->end_date)) {
            $query = $query->whereBetween('appointments.date', [$request->start_date, $request->end_date]);
        }

        if(isset($request->state)) {
            $query = $query->where('appointments.state_id', $request->state);
        }

        if($request->city !== '0') {
            $query = $query->where('appointments.city_id', $request->city);
        }

        $appointments = $query
            ->join('cities', 'cities.id', '=', 'appointments.city_id')
            ->select('appointments.*', 'cities.description')
            ->paginate(20);

        return $appointments;
    }

    public function generatePDF(Request $request) {
        try {
            $appointments = $this->filterApply($request);

            $situations = AppointmentSituation::orderBy('description', 'ASC')->get();
            $types = AppointmentType::orderBy('description', 'ASC')->get();
            $cities = City::orderBy('description', 'ASC')->get();
            $administrations = AppointmentAdministration::orderBy('description', 'ASC')->get();

            $pdfData = [];

            foreach($appointments as $appointment) {
                $pdfData[] = [
                    'administration' => $administrations->find($appointment->administration)->description,
                    'tipo' => $types->find($appointment->type)->description,
                    'city' => $cities->find($appointment->city->id)->description,
                    'date' => $appointment->date,
                    'name' => $appointment->name,
                    'phone' => $appointment->phone,
                    'situation' => $situations->find($appointment->situation)->description,
                    'reference' => $appointment->reference,
                    'responsible' => $appointment->responsible
                ];
            }

            $data = [
                'title' => 'Atendimentos',
                'date' => date('m/d/Y'),
                'headers' => [
                    'Administração',
                    'Tipo',
                    'Município',
                    'Data',
                    'Nome',
                    'Telefone',
                    'Situação',
                    'Referência',
                    'Responsável'
                ],
                'data' => $pdfData
            ];

            $pdf = PDF::loadView('PDF.list', $data);

            return $pdf->download('documento.pdf');
        } catch(Exception $e) {
            return redirect()
                ->action([AppointmentController::class, 'index'])
                ->withErrors($e->getMessage());
        }
    }
}
