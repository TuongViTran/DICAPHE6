<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id); // Lấy thông tin người dùng theo ID
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        
        $user->save(); // Lưu lại thông tin
        return redirect()->route('profile.edit', $id)->with('success', 'Cập nhật thông tin thành công!');
    }
}