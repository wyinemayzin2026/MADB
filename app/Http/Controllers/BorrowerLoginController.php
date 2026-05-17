<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowerLoginController extends Controller
{
    // Login စာမျက်နှာကို ပြသရန်
    public function showLoginForm()
    {
        // အကယ်၍ အသုံးပြုသူက Login ဝင်ပြီးသားဖြစ်နေပါက Dashboard သို့ တန်းပို့မည်
        if (Auth::guard('borrower')->check()) {
            return redirect()->route('home');
        }
        return view('home');
    }

    // Login ဒေတာများကို လက်ခံစစ်ဆေးရန်
    public function loginSubmit(Request $request)
    {
        // ၁။ NRC ကို ၁၄/ဟသတ(N)370020 ပုံစံသို့ စုစည်းပေါင်းစပ်ခြင်း
        if ($request->filled(['nrc_state', 'nrc_township', 'nrc_type', 'nrc_digits'])) {
            $nrcNumber = $request->nrc_state . '/' . $request->nrc_township . $request->nrc_type . $request->nrc_digits;
            $request->merge(['nrc_number' => $nrcNumber]);
        } else {
            $request->merge(['nrc_number' => null]);
        }

        // ၂။ ပြည့်စုံသော မြန်မာလို Validation စစ်ဆေးခြင်း
        $credentials = $request->validate([
            'nrc_number' => 'required|string',
            'password' => 'required|string|min:8',
        ], [
            'nrc_number.required' => 'မှတ်ပုံတင်နံပါတ်ကို အပြည့်အစုံ ရွေးချယ်/ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။',
            'password.required' => 'လျှို့ဝှက်နံပါတ် (Password) ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
        ]);

        // ၃။ Auth Guard ဖြင့် စနစ်ထဲဝင်ရန် ကြိုးစားခြင်း
        if (
            Auth::guard('borrower')->attempt([
                'nrc_number' => $credentials['nrc_number'],
                'password' => $credentials['password']
            ])
        ) {

            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'မင်္ဂလာပါ၊ စနစ်ထဲသို့ အောင်မြင်စွာ ဝင်ရောက်ပြီးပါပြီ။');
        }

        // လော့ဂ်အင်မအောင်မြင်ပါက Error စာသားပြန်ပြရန်
        return back()->withErrors([
            'login_error' => 'ရိုက်ထည့်ထားသော မှတ်ပုံတင်နံပါတ် သို့မဟုတ် လျှို့ဝှက်နံပါတ် မှားယွင်းနေပါသည်။',
        ])->withInput($request->except('password'));
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        // Borrower Guard စနစ်မှ ထွက်ခွာခြင်း
        Auth::guard('borrower')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ပင်မစာမျက်နှာသို့ ပြန်လည် ပို့ဆောင်ခြင်း
        return redirect('/')->with('success', 'စနစ်ထဲမှ အောင်မြင်စွာ ထွက်ပြီးပါပြီ။');
    }
}
