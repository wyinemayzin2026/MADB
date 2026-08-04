<?php

namespace App\Http\Controllers;

use App\Models\Borrower; // Borrower Model ကို တိုက်ရိုက်သုံးစွဲမည်
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BorrowerController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrower::latest();

        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        $accounts = $query->paginate(10)->withQueryString();

        return view('staff.borrowers.list', compact('accounts'));
    }

    public function staffList(Request $request)
    {
        $query = Staff::latest();

        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        $accounts = $query->paginate(10)->withQueryString();
        return view('staff.staff.list', compact('accounts'));
    }

    public function store(Request $request)
    {
        if ($request->filled(['nrc_state', 'nrc_township', 'nrc_type', 'nrc_digits'])) {
            $nrcNumber = $request->nrc_state . '/' . $request->nrc_township . $request->nrc_type . $request->nrc_digits;
            $request->merge(['nrc_number' => $nrcNumber]);
        } else {
            $request->merge(['nrc_number' => null]);
        }

        $validated = $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?!.*[0-9\x{1040}-\x{1049}]).*$/u'
            ],
            'nrc_number' => [
                'required',
                'string',
                'max:255',
                'unique:borrowers,nrc_number',
                'regex:/^[\x{1000}-\x{109F}a-zA-Z0-9\/\(\)]+$/u'
            ],

            'phone_number' => [
                'required',
                'string',
                'regex:/^(09|၀၉)(2|4|5|6|7|8|9|၂|၄|၅|၆|၇|၈|၉)[0-9\x{1040}-\x{1049}]{8}$/u'
            ],

            'email' => 'nullable|email|max:255|unique:borrowers,email',
            'date_of_birth' => 'required|date',
            'gender' => [
                'required',
                'in:male,female,other',
                function ($attribute, $value, $fail) use ($request) {
                    $name = trim($request->input('full_name'));

                    // နာမည်အစ ရှေ့ဆုံး စာလုံးများကို စစ်ဆေးခြင်း
                    if ($value === 'male') {
                        if (preg_match('/^(ဒေါ်|မ)\b/u', $name) || preg_match('/^(ဒေါ်|မ)/u', $name)) {
                            $fail('အမည်တွင် "ဒေါ်" သို့မဟုတ် "မ" ပါဝင်နေပါသဖြင့် ကျား/မ နေရာတွင် "မ" သာ ရွေးချယ်ရပါမည်။');
                        }
                    } elseif ($value === 'female') {
                        if (preg_match('/^(ဦး|ဦး|မောင်|ကို)\b/u', $name) || preg_match('/^(ဦး|ဦး|မောင်|ကို)/u', $name)) {
                            $fail('အမည်တွင် "ဦး/မောင်/ကို" ပါဝင်နေပါသဖြင့် ကျား/မ နေရာတွင် "ကျား" သာ ရွေးချယ်ရပါမည်။');
                        }
                    }
                }
            ],
            'address' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'full_name.required' => 'နာမည်အပြည့်အစုံကို ဖြည့်စွက်ပေးရန် လိုအပ်ပါသည်။',
            'full_name.string' => 'နာမည်သည် စာသားအမျိုးအစား ဖြစ်ရပါမည်။',
            'full_name.max' => 'နာမည်သည် စာလုံးရေ ၂၅၅ လုံးထက် မကျော်ရပါ။',
            'full_name.regex' => 'အမည်တွင် ကိန်းဂဏန်းများ (၁၂၃ / 123) ထည့်သွင်း၍ မရပါ။',

            'nrc_number.required' => 'မှတ်ပုံတင်နံပါတ်ကို အပြည့်အစုံ ရွေးချယ်/ဖြည့်သွင်းပေးရန် လိုအပ်ပါသည်။',
            'nrc_number.unique' => 'ဤမှတ်ပုံတင်နံပါတ်သည် စနစ်ထဲတွင် ရှိနှင့်ပြီးသားဖြစ်ပါသည်။',

            'phone_number.required' => 'ဆက်သွယ်ရန်ဖုန်းနံပါတ်ကို ဖြည့်စွက်ပေးရန် လိုအပ်ပါသည်။',
            'phone_number.regex' => 'ဖုန်းနံပါတ်သည် 09 သို့မဟုတ် ၀၉ ဖြင့်စပြီး ၁၁ လုံး အတိရှိရမည်ဖြစ်ကာ မှန်ကန်သော MPT, ATOM, Ooredoo, Mytel ဖုန်းနံပါတ် ဖြစ်ရပါမည်။',

            'email.email' => 'မှန်ကန်သော အီးမေးလ် ပုံစံ ဖြစ်ရပါမည်။',
            'email.max' => 'အီးမေးလ် သည် စာလုံးရေ ၂၅၅ လုံးထက် မကျော်ရပါ။',
            'email.unique' => 'ဤ အီးမေးလ် သည် စနစ်ထဲတွင် ရှိနှင့်ပြီးသားဖြစ်ပါသည်။',
            'nrc_number.regex' => 'မှတ်ပုံတင်နံပါတ်ကို မြန်မာဂဏန်းနှင့် မြန်မာစာလုံးများဖြင့်သာ ဖြည့်သွင်းပေးပါ။ (ဥပမာ - ၁၂/ရခန(နိုင်)၁၂၃၄၅၆)',
            'date_of_birth.required' => 'မွေးနေ့ရက်စွဲကို ရွေးချယ်ပေးရန် လိုအပ်ပါသည်။',
            'date_of_birth.date' => 'မွေးနေ့သည် မှန်ကန်သော ရက်စွဲပုံစံ ဖြစ်ရပါမည်။',

            'gender.required' => 'ကျား/မ အမျိုးအစားကို ရွေးချယ်ပေးရန် လိုအပ်ပါသည်။',
            'gender.in' => 'ရွေးချယ်ထားသော ကျား/မ အမျိုးအစားသည် မမှန်ကန်ပါ။',
            'address.required' => 'နေရပ်လိပ်စာကို ဖြည့်စွက်ပေးရန် လိုအပ်ပါသည်။',
            'password.required' => 'လျှို့ဝှက်နံပါတ် (Password) ကို ဖြည့်စွက်ပေးရန် လိုအပ်ပါသည်။',
            'password.min' => 'လျှို့ဝှက်နံပါတ်သည် အနည်းဆုံး စာလုံးရေ ၈ လုံး ရှိရပါမည်။',
            'password.confirmed' => 'ရိုက်ထည့်ထားသော လျှို့ဝှက်နံပါတ် နှစ်ခု တိုက်ဆိုင်မှု မရှိပါ။',
        ]);

        $validated['password'] = Hash::make($request->password);

        Borrower::create($validated);

        return redirect()->route('borrowers.list')->with('success', 'ငွေစုစာရင်းအကောင့်အသစ် ဖွင့်လှစ်ပြီးပါပြီ။');
    }

    public function update(Request $request, $id)
    {
        $account = Borrower::findOrFail($id);

        if ($request->filled(['nrc_state', 'nrc_township', 'nrc_type', 'nrc_digits'])) {
            $nrcNumber = $request->nrc_state . '/' . $request->nrc_township . $request->nrc_type . $request->nrc_digits;
            $request->merge(['nrc_number' => $nrcNumber]);
        } else {
            $request->merge(['nrc_number' => null]);
        }

        $validated = $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?!.*[0-9\x{1040}-\x{1049}]).*$/u'
            ],
            'nrc_number' => [
                'required',
                'string',
                'max:255',
                'unique:borrowers,nrc_number,' . $id,
                'regex:/^[\x{1000}-\x{109F}a-zA-Z0-9\/\(\)]+$/u'
            ],
            'phone_number' => [
                'required',
                'string',
                'regex:/^(09|၀၉)(2|4|5|6|7|8|9|၂|၄|၅|၆|၇|၈|၉)[0-9\x{1040}-\x{1049}]{8}$/u'
            ],
            'email' => 'nullable|email|max:255|unique:borrowers,email,' . $id,
            'date_of_birth' => 'required|date',
            'gender' => [
                'required',
                'in:male,female,other',
                function ($attribute, $value, $fail) use ($request) {
                    $name = trim($request->input('full_name'));

                    if ($value === 'male') {
                        if (preg_match('/^(ဒေါ်|မ)\b/u', $name) || preg_match('/^(ဒေါ်|မ)/u', $name)) {
                            $fail('အမည်တွင် "ဒေါ်" သို့မဟုတ် "မ" ပါဝင်နေပါသဖြင့် ကျား/မ နေရာတွင် "မ" သာ ရွေးချယ်ရပါမည်။');
                        }
                    } elseif ($value === 'female') {
                        if (preg_match('/^(ဦး|ဦး|မောင်|ကို)\b/u', $name) || preg_match('/^(ဦး|ဦး|မောင်|ကို)/u', $name)) {
                            $fail('အမည်တွင် "ဦး/မောင်/ကို" ပါဝင်နေပါသဖြင့် ကျား/မ နေရာတွင် "ကျား" သာ ရွေးချယ်ရပါမည်။');
                        }
                    }
                }
            ],
            'address' => 'required|string',
            'password' => 'nullable|string|min:8',
        ], [
            'full_name.required' => 'နာမည်အပြည့်အစုံကို ဖြည့်စွက်ပေးရန် လိုအပ်ပါသည်။',
            'full_name.string' => 'နာမည်သည် စာသားအမျိုးအစား ဖြစ်ရပါမည်။',
            'full_name.max' => 'နာမည်သည် စာလုံးရေ ၂၅၅ လုံးထက် မကျော်ရပါ။',
            'full_name.regex' => 'အမည်တွင် ကိန်းဂဏန်းများ (၁၂၃ / 123) ထည့်သွင်း၍ မရပါ။',

            'nrc_number.required' => 'မှတ်ပုံတင်နံပါတ်ကို အပြည့်အစုံ ဖြည့်စွက်ပေးရန် လိုအပ်ပါသည်။',
            'nrc_number.unique' => 'ဤမှတ်ပုံတင်နံပါတ်သည် စနစ်ထဲတွင် ရှိနှင့်ပြီးသားဖြစ်ပါသည်။',

            'phone_number.required' => 'ဆက်သွယ်ရန်ဖုန်းနံပါတ်ကို ဖြည့်စွက်ပေးရန် လိုအပ်ပါသည်။',
            'phone_number.regex' => 'ဖုန်းနံပါတ်သည် 09 သို့မဟုတ် ၀၉ ဖြင့်စပြီး ၁၁ လုံး အတိရှိရမည်ဖြစ်ကာ မှန်ကန်သော MPT, ATOM, Ooredoo, Mytel ဖုန်းနံပါတ် ဖြစ်ရပါမည်။',
            'nrc_number.regex' => 'မှတ်ပုံတင်နံပါတ်ကို မြန်မာဂဏန်းနှင့် မြန်မာစာလုံးများဖြင့်သာ ဖြည့်သွင်းပေးပါ။ (ဥပမာ - ၁၂/ရခန(နိုင်)၁၂၃၄၅၆)',
            'email.email' => 'မှန်ကန်သော အီးမေးလ် ပုံစံ ဖြစ်ရပါမည်။',
            'email.max' => 'အီးမေးလ် သည် စာလုံးရေ ၂၅၅ လုံးထက် မကျော်ရပါ။',
            'email.unique' => 'ဤ အီးမေးလ် သည် စနစ်ထဲတွင် ရှိနှင့်ပြီးသားဖြစ်ပါသည်။',

            'date_of_birth.required' => 'မွေးနေ့ရက်စွဲကို ရွေးချယ်ပေးရန် လိုအပ်ပါသည်။',
            'date_of_birth.date' => 'မွေးနေ့သည် မှန်ကန်သော ရက်စွဲပုံစံ ဖြစ်ရပါမည်။',

            'gender.required' => 'ကျား/မ အမျိုးအစားကို ရွေးချယ်ပေးရန် လိုအပ်ပါသည်။',
            'gender.in' => 'ရွေးချယ်ထားသော ကျား/မ အမျိုးအစားသည် မမှန်ကန်ပါ။',
            'address.required' => 'နေရပ်လိပ်စာကို ဖြည့်စွက်ပေးရန် လိုအပ်ပါသည်။',
            'password.min' => 'လျှို့ဝှက်နံပါတ်သည် အနည်းဆုံး စာလုံးရေ ၈ လုံး ရှိရပါမည်။',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $account->update($validated);

        return redirect()->route('borrowers.list')->with('success', 'အကောင့်အချက်အလက်များကို ပြင်ဆင်ပြီးပါပြီ။');
    }

    public function destroy($id)
    {
        $account = Borrower::findOrFail($id);
        $account->delete();

        return redirect()->route('borrowers.list')->with('success', 'အကောင့်စာရင်းကို ပယ်ဖျက်ပြီးပါပြီ။');
    }
}
