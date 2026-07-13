<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Borrower;
use App\Models\BorrowerLoan;
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
        // 1. Data for Status Stacked Chart
        $statusStats = BorrowerLoan::select('loan_type', 'status')
            ->selectRaw('SUM(total_amount) as total')
            ->groupBy('loan_type', 'status')
            ->get();

        $chartDataStatus = $statusStats->groupBy('loan_type')->map(function ($items) {
            return $items->pluck('total', 'status');
        });

        // 2. Data for Seasonal Comparison Chart
        $seasonStats = BorrowerLoan::select('loan_type', 'season_type')
            ->selectRaw('SUM(total_amount) as total')
            ->groupBy('loan_type', 'season_type')
            ->get();

        $chartDataSeason = $seasonStats->groupBy('loan_type')->map(function ($items) {
            return [
                'rainy' => $items->where('season_type', 'rainy')->sum('total'),
                'winter' => $items->where('season_type', 'winter')->sum('total'),
            ];
        });

        // Summary Cards Data
        $totalBorrower = Borrower::count();
        $todayLoanAmount = BorrowerLoan::sum('total_amount');
        $winterLoanCount = BorrowerLoan::where('season_type', 'winter')->count();
        $rainLoanCount = BorrowerLoan::where('season_type', 'rainy')->count();
        $allStatuses = ['pending', 'approved', 'rejected'];

        return view('staff.dashboard', compact(
            'chartDataStatus',
            'chartDataSeason',
            'allStatuses',
            'totalBorrower',
            'todayLoanAmount',
            'winterLoanCount',
            'rainLoanCount'
        ));
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
