<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    public function index()
    {
        return view ('Session.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validation($request);
            
            if($validator->fails()) {
                return redirect('/sie/login')->withErrors($validator);
            }

            $user = User::with('profile')->where('login', $request->login)->first();
            
            $groups = [];

            foreach($user->profile->permissions as $permission) {
                $key = Str::ucfirst($permission->parent);

                $groups[$key][] = $permission;
            }

            $user->profile->groups = $groups;

            $user->profile->permissions = null;

            if (!isset($user) ) {
                return redirect('/sie/login')->withErrors(['Usuário não foi encontrado.']);
            }

            if ($user->password != $request->password) {
                return redirect('/sie/login')->withErrors(['Senha incorreta.']);
            }

            $request->session()->put('user', $user);

            return redirect('/sie/home');
        } catch(Exception $e) {
            return redirect()
                ->action([SessionController::class, 'index'])
                ->withErrors($e->getMessage());
        }
    }

    public function destroy()
    {
        session()->flush();
        return redirect('/sie/login');
    }

    private function validation(Request $request) {
        $validationRules = [
            'login' => 'required',
            'password' => 'required'
        ];

        $replacements = [
            'password' => 'senha'
        ];

        $validator = Validator::make($request->all(), $validationRules, [], $replacements);

        return $validator;
    }
}
