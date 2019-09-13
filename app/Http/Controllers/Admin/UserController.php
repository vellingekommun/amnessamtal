<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class UserController extends controller
{

    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $data = $request->all();

        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        
        if($user->save()){
            flash('Användaren är skapad.')->success();
        } else {
            flash('Ett okänt fel har uppstått, användaren kunde inte skapas.')->error();
        }
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];

        if ($password = $request->get('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $this->validate($request, $rules);

        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
        ];

        if ($password) {
            $data['password'] = Hash::make($data['password']);
        }

        if($user->update($data)){
            flash('Användaren är uppdaterad.')->success();
        } else {
            flash('Ett okänt fel har uppstått, användaren kunde inte uppdateras.')->error();
        }

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        if($user->id != Auth::user()->getKey() && $user->delete()){
            flash('Användaren är borttagen.')->success();
        } else {
            flash('Ett okänt fel har uppstått, användaren kunde inte tas bort.')->error();
        }
        return redirect()->route('users.index');
    }

}
