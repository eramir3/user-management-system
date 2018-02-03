<?php

namespace App\Http\Controllers;

use Session;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UsersEditRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_active == 0 || Auth::user()->role_id == 3) {

            return view('home');
        }

        if(Auth::user()->role_id == 2 && Auth::user()->permiso_lectura == 0) {

            return view('home');
        } 

        $users = User::all();
        return view('usuarios.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        if(Auth::user()->is_active == 0 || Auth::user()->role_id != $user->role_id) {

            return view('home');
        }

        $roles = Role::pluck('name','id');
        return view('usuarios.edit', compact('user','roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->is_active == 0 || Auth::user()->role_id != 1) {

            return view('home');
        }

        $user = User::findOrFail($id);

        $roles = Role::pluck('name','id');
        return view('usuarios.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        $user = User::findOrFail($id);
        
        if(trim($request->password) == '') {
            
            $input = $request->except(['password']);
        }
        else {
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }

        //dd($input);

        $user->update($input);

        Session::flash('success', 'El usuario ha sido actualizado exitosamente');

        return redirect()->back();
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

        if(Auth::user()->id == $user->id) {

            Auth::logout();
            Session::flush();
            $user->delete();
            return redirect('/');
        }

        $user->delete();

        Session::flash('success', 'El usuario fue eliminado exitosamente');

        return redirect()->back();
    }
}
