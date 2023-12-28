<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Exception;

class UserController extends Controller {
    public function index() {
        $users = DB::table('users')
            ->select('id', 'name', 'login', 'password')
            ->get();

        return view('User.list', ['users' => $users]);
    }

    public function create() {
        return view('User.create');
    }

    public function store(Request $request) {
        try {
            $validator = $this->validation($request);

            if($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            $user = new User;

            $user->name = $request->name;
            $user->login = $request->login;
            $user->password = $request->password;

            // Criptografia MD5 (documentação)
            // https://laravel.com/docs/8.x/helpers#method-fluent-str-pipe

            $user->save();

            return redirect()
                ->action([SessionController::class, 'index'])
                ->with('notification', [
                    'message' => 'Usuário '.$user->name.' cadastrado com sucesso!',
                    'type' => 'success'
                ]);
        } catch(Exception $e) {
            return redirect()
                ->action([UserController::class, 'create'])
                ->withErrors($e->getMessage());
        }
    }

    public function destroy($id) {
        User::findOrFail($id)->delete();

        return redirect()->action([UserController::class, 'index']);
    }

    public function edit($id) {
        $user = User::findOrFail($id);

        return view('User.create')->with('user', $user);
    }

    public function update($id, Request $request) {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->login = $request->login;
        $user->password = $request->password;

        $user->save();

        return redirect()
            ->action([UserController::class, 'index'])
            ->with('notification', [
                'message' => 'Usuário ' . $user->name . ' atualizado com sucesso!',
                'type' => 'success'
            ]);
    }

    private function validation(Request $request) {
        $validationRules = [
            'name' => 'required',
            'login' => 'required',
            'password' => 'required|min:6'
        ];

        $replacements = [
            'name' => 'nome',
            'password' => 'senha'
        ];

        $validator = Validator::make($request->all(), $validationRules, [], $replacements);

        return $validator;
    }
}
