<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::all(); 
        $aiStatus = \App\Models\Setting::first(); 
        
        return view('admin.index', compact('users', 'aiStatus'));
    }
    public function toggleAI()
    {
        $setting = Setting::first();
        if ($setting) {
            $setting->update(['ai_active' => !$setting->ai_active]);
        }
        return back()->with('success', 'Status Sistem AI Berhasil Diperbarui!');
    }

    // app/Http/Controllers/AdminController.php

    public function storeUser(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'Kapten Baru Berhasil Direkrut!');
    }

    public function updateUser(Request $request, $id) {
        $user = \App\Models\User::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return back()->with('success', 'Data Kapten Berhasil Diperbarui!');
    }

    public function destroyUser($id) {
        if($id == auth()->id()) return back(); // Jangan hapus diri sendiri!
        
        \App\Models\User::destroy($id);
        return back()->with('success', 'Kapten Berhasil Dikeluarkan!');
    }

    // FUNGSI BARU: UPDATE PERSONA ROBOT
    public function updatePrompt(Request $request)
    {
        $request->validate([
            'system_prompt' => 'required|string',
        ]);

        $setting = Setting::first();
        if ($setting) {
            $setting->update(['system_prompt' => $request->system_prompt]);
        } else {
            // Jaga-jaga kalau setting belum ada (jarang terjadi)
            Setting::create(['system_prompt' => $request->system_prompt]);
        }

        return back()->with('success', 'Kepribadian Robot Berhasil Diubah! 🧠');
    }
}