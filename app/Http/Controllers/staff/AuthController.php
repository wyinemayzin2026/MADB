<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.staff_login');
    }

    // Login Logic
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'eid' => ['required', 'numeric'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('staff.dashboard'));
        }

        return back()->withErrors([
            'eid' => 'ဝန်ထမ်းအမှတ် သို့မဟုတ် လျှို့ဝှက်နံပါတ် မှားယွင်းနေပါသည်။',
        ])->onlyInput('eid');
    }

    public function showStaffDashboard()
    {
        return view('staff.dashboard');
    }

    // Logout Logic
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image',
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_image')) {
            if ($user->image_path) {
                Storage::disk('public')->delete($user->image_path);
            }

            $path = $request->file('profile_image')->store('profile_images', 'public');

            $user->update([
                'image_path' => $path
            ]);

            return response()->json([
                'success' => true,
                'image_url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['success' => false], 400);
    }
}
