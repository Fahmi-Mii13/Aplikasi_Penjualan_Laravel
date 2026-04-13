<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|unique:users',
            'name' => 'required',
            'role' => ['required', Rule::in(['superadmin', 'admin', 'operator'])],
            'password' => 'required|min:4'
        ]);
        
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'username' => 'required|unique:users,username,'.$user->id,
            'name' => 'required',
            'role' => ['required', Rule::in(['superadmin', 'admin', 'operator'])],
            'password' => 'nullable|min:4'
        ]);
        
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        
        $user->update($data);
        return redirect()->route('users.index')->with('success', 'User berhasil diubah.');
    }

    public function destroy(User $user)
    {
        if(auth()->user()->id === $user->id) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus diri sendiri!');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
