<?php

namespace App\Http\Controllers\Modules\Register;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Register\Company;
use Validator;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('modules.register.user.list')->with('title', 'Usuários')
                                                 ->with('menu', 'user')
                                                 ->with('users', $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email",
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6'
            ]);
        if($v->fails()){
            return back()->withErrors($v);
        }

        $data = $request->all();
        $data['company'] = auth()->user()->company;
        $data['name'] = trim($data['name']);
        $data['email'] = trim($data['email']);
        $data['password'] = Hash::make(trim($data['password']));

        User::create($data);
        return back()->with('success', 'Usuário criado com sucesso');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $v = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email"
            ]);
        if($v->fails()){
            return back()->withErrors($v);
        }

        $user = User::findOrFail($id);

        $user->update([
                "name" => $request->name,
                "email" => $request->email
            ]);

        return back()->with('success', 'Usuário atualizado com sucesso');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $companyUsers = Company::findOrFail($user->company)->users();

        if ($companyUsers->count() <= 1) {
            return back()->withErrors(['É preciso ter ao menos um usuário ativo']);
        }

        $user->delete();

        return back()->with('success', 'Usuário eliminado com sucesso');
    }

    public function passReset(Request $request)
    {
        $v = Validator::make($request->all(), [
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6'
            ]);
        if($v->fails()){
            return back()->withErrors($v);
        }

        $user = User::findOrFail($request->id);
        $user->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Senha alterada com sucesso');
    }
}
