<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact;
use Exception;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if($request->input('sort') !== null) {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $contacts = Contact::orderBy($sortColumn, $sortDirection);
        } else {
            $contacts = Contact::orderBy('name', 'ASC');
        }

        $contacts = $contacts
            ->join('cities', 'cities.id', '=', 'contacts.city_id')
            ->join('states', 'states.id', '=', 'contacts.state_id')
            ->select('contacts.*', 'cities.description')
            ->paginate(20);

        return view ('List.Contact.list', ['contacts' => $contacts]);
    }

    public function show($id) {
        $contact = Contact::findOrFail($id);

        return view('Details.Contact.details', [
            'contact' => $contact
        ]);
    }

    public function create()
    {
        return view('Store.Contact.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validation($request);

            if($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            DB::beginTransaction();

            $contact = new Contact;

            $contact->name = $request->name;
            $contact->nick = $request->nick;
            $contact->birthdate = $request->birthdate;
            $contact->gender = $request->gender;
            $contact->type = $request->type;
            $contact->occupation = $request->occupation;

            $contact->cep = $request->cep;
            $contact->state_id = $request->state;
            $contact->city_id = $request->city;
            $contact->district = $request->district;
            $contact->address = $request->address;
            $contact->complement = $request->complement;

            $contact->email = $request->email;
            $contact->landline = $request->landline;
            $contact->phone = $request->phone;
            $contact->phone_2 = $request->phone_2;
            $contact->observation = $request->observation;
            $contact->political_info = $request->political_info;

            $contact->save();

            DB::commit();

            return redirect()
                ->action([ContactController::class, 'index'])
                ->with('notification', [
                    'message' => 'Contato cadastrado com sucesso!',
                    'type' => 'success'
            ]);

        } catch(Exception $e) {
            DB::rollback();

            return redirect()
                ->action([ContactController::class, 'create'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);

        return view('Store.Contact.create')->with('contact', $contact);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $contact = Contact::findOrFail($id);

            $contact->name = $request->name;
            $contact->nick = $request->nick;
            $contact->birthdate = $request->birthdate;
            $contact->gender = $request->gender;
            $contact->type = $request->type;
            $contact->occupation = $request->occupation;

            $contact->cep = $request->cep;
            $contact->state_id = $request->state;
            $contact->city_id = $request->city;
            $contact->district = $request->district;
            $contact->address = $request->address;
            $contact->complement = $request->complement;

            $contact->email = $request->email;
            $contact->landline = $request->landline;
            $contact->phone = $request->phone;
            $contact->phone_2 = $request->phone_2;
            $contact->observation = $request->observation;
            $contact->political_info = $request->political_info;

            $contact->save();

            DB::commit();

            return redirect()
                ->action([ContactController::class, 'index'])
                ->with('notification', [
                    'message' => 'O contato '.$contact->name.' foi atualizado com sucesso!',
                    'type' => 'success'
            ]);
        } catch(Exception $e) {
            return redirect()
                ->action([ContactController::class, 'edit'])
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            Contact::findOrFail($id)->delete();

            return redirect()
                ->action([ContactController::class, 'index'])
                ->with('notification', [
                    'message' => 'Contato removido com sucesso!',
                    'type' => 'success'
                ]);

        } catch(Exception $e) {
            return redirect()
                ->action([ContactController::class, 'index'])
                ->withErrors($e->getMessage());
        }
    }

    public function filter(Request $request)
    {
        $contacts = $this->filterApply($request);

        return view ('List.Contact.list', [
            'contacts' => $contacts
        ]);
    }

    private function filterApply(Request $request) {
        if($request->input('sort') === null) {
            $query = Contact::orderBy('contacts.name', 'DESC');
        } else {
            $sortColumn = $request->input('sort');
            $sortDirection = $request->input('direction');

            $query = Contact::orderBy($sortColumn, $sortDirection);
        }

        if($request->month !== '0') {
            $query = $query->whereMonth('contacts.birthdate', $request->month);
        }

        $contacts = $query
            ->join('cities', 'cities.id', '=', 'contacts.city_id')
            ->select('contacts.*', 'cities.description')
            ->paginate(20);

        return $contacts;
    }

    private function validation(Request $request) {
        $validationRules = [
            'name' => 'required|max:100',
            'gender' => 'required|size:1',
            'type' => 'required',
            'occupation' => 'required',
            'state' => 'required',
            'city' => 'required|integer',
            'date' => 'regex:/^\d{4}-\d{2}-\d{2}$/i',
            'cep' => 'regex:/^\d{5}-\d{3}$/i'
        ];

        $replacements = [
            'occupation' => 'ocupação',
            'cep' => 'CEP'
        ];

        $validator = Validator::make($request->all(), $validationRules, [], $replacements);

        return $validator;
    }
}
