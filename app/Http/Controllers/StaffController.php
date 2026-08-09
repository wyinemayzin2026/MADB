<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::where('role', '!=', 'admin')
            ->latest()
            ->get();

        if (auth()->user()->role !== 'admin') {
            abort(404);
        }

        return view('staff.staff.list', compact('staffs'));
    }

    public function store(Request $request)
    {
        $staffCount = Staff::where('role', '!=', 'admin')->count();

        if ($staffCount >= 30) {
            return redirect()->back()->with('error', '၀န်ထမ်းအကောင့် အများဆုံး (၃၀) သာ ထည့်သွင်းခွင့်ရှိပါသည်။');
        }
        $validated = $request->validate([
            'eid' => 'required|numeric|unique:staff,eid',
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?!.*[0-9\x{1040}-\x{1049}]).*$/u'
            ],
            'email' => 'required|email|unique:staff,email',
            'position' => 'required|string|max:255',
            'role' => 'required|string|in:staff,manager,admin',
            'phone' => [
                'required',
                'string',
                'max:15',
                'regex:/^(09|\+?959|၀၉|\+?၉၅၉)[0-9\x{1040}-\x{1049}]{7,9}$/u'
            ],
            'address' => 'nullable|string',
            'password' => 'required|string|min:6',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            // Custom Myanmar Messages
            'eid.required' => 'EID (ဝန်ထမ်းနံပါတ်) ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
            'eid.numeric' => 'EID သည် ကိန်းဂဏန်းသာ ဖြစ်ရပါမည်။',
            'eid.unique' => 'ဤ EID ကို အသုံးပြုပြီးသား ဖြစ်နေပါသည်။',
            'name.regex' => 'အမည်တွင် ကိန်းဂဏန်းများ (၁၂၃ / 123) ထည့်သွင်း၍ မရပါ။',

            'name.required' => 'ဝန်ထမ်းအမည် ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',

            'email.required' => 'အီးမေးလ် ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
            'email.email' => 'မှန်ကန်သော အီးမေးလ် ပုံစံ ဖြစ်ရပါမည်။',
            'email.unique' => 'ဤ အီးမေးလ်ကို အသုံးပြုပြီးသား ဖြစ်နေပါသည်။',

            'position.required' => 'ရာထူး ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
            'role.required' => 'Role ရွေးချယ်ရန် လိုအပ်ပါသည်။',
            'phone.max' => 'ဖုန်းနံပါတ်သည် အများဆုံး ၁၅ လုံးထက် မပိုရပါ။',
            'phone.regex' => 'မှန်ကန်သော မြန်မာဖုန်းနံပါတ် ဖြစ်ရပါမည်။ (ဥပမာ - 09661678119)',
            'phone_number.required' => 'ဆက်သွယ်ရန်ဖုန်းနံပါတ်ကို ဖြည့်စွက်ပေးရန် လိုအပ်ပါသည်။',
            'password.required' => 'လျှို့ဝှက်နံပါတ် ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
            'password.min' => 'လျှို့ဝှက်နံပါတ်သည် အနည်းဆုံး ၆ လုံး ရှိရပါမည်။',

            'image.image' => 'ဖိုင်ပုံစံသည် ဓာတ်ပုံ (Image) သာ ဖြစ်ရပါမည်။',
            'image.mimes' => 'jpeg, png, jpg, gif ပုံစံများသာ တင်ခွင့်ရှိပါသည်။',
            'image.max' => 'ဓာတ်ပုံဖိုင်ပမာဏသည် 2MB ထက် မပိုရပါ။'
        ]);

        if ($request->hasFile('image_path')) {
            // File ပုံကို Storage ထဲ သိမ်းပြီး String Path အဖြစ် လဲလှယ်မည်
            $validated['image_path'] = $request->file('image_path')->store('staff_images', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);

        Staff::create($validated);

        return redirect()->back()->with('success', '၀န်ထမ်းအကောင့် အသစ်ထည့်သွင်းပြီးပါပြီ။');
    }

    public function edit(Staff $staff)
    {
        return response()->json($staff);
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'eid' => 'required|integer|unique:staff,eid,' . $staff->id,
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?!.*[0-9\x{1040}-\x{1049}]).*$/u'
            ],
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'position' => 'required|string|max:255',
            'role' => 'required|string',
            'phone' => [
                'required',
                'string',
                'max:15',
                'regex:/^(09|\+?959|၀၉|\+?၉၅၉)[0-9\x{1040}-\x{1049}]{7,9}$/u'
            ],
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'eid.required' => 'EID (ဝန်ထမ်းနံပါတ်) ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
            'name.regex' => 'အမည်တွင် ကိန်းဂဏန်းများ (၁၂၃ / 123) ထည့်သွင်း၍ မရပါ။',
            'eid.integer' => 'EID သည် ကိန်းဂဏန်း (ကင်းပြည့်) သာ ဖြစ်ရပါမည်။',
            'eid.unique' => 'ဤ EID ကို အခြားဝန်ထမ်းတစ်ဦးတွင် အသုံးပြုပြီးသား ဖြစ်နေပါသည်။',

            'name.required' => 'ဝန်ထမ်းအမည် ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
            'name.max' => 'ဝန်ထမ်းအမည်သည် စာလုံးရေ ၂၅၅ လုံးထက် မပိုရပါ။',

            'phone.max' => 'ဖုန်းနံပါတ်သည် အများဆုံး ၁၅ လုံးထက် မပိုရပါ။',
            'phone.regex' => 'မှန်ကန်သော မြန်မာဖုန်းနံပါတ် ဖြစ်ရပါမည်။ (ဥပမာ - 09661678119)',
            'phone_number.required' => 'ဆက်သွယ်ရန်ဖုန်းနံပါတ်ကို ဖြည့်စွက်ပေးရန် လိုအပ်ပါသည်။',
            'email.required' => 'အီးမေးလ် ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
            'email.email' => 'မှန်ကန်သော အီးမေးလ် ပုံစံ ဖြစ်ရပါမည်။',
            'email.unique' => 'ဤ အီးမေးလ်ကို အခြားဝန်ထမ်းတစ်ဦးတွင် အသုံးပြုပြီးသား ဖြစ်နေပါသည်။',

            'position.required' => 'ရာထူး ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
            'role.required' => 'Role (ရာထူးအဆင့်) ရွေးချယ်ရန် လိုအပ်ပါသည်။',

            'password.min' => 'လျှို့ဝှက်နံပါတ် အသစ်ပြောင်းပါက အနည်းဆုံး ၆ လုံး ရှိရပါမည်။',

            'image.image' => 'ဖိုင်ပုံစံသည် ဓာတ်ပုံ (Image) သာ ဖြစ်ရပါမည်။',
            'image.mimes' => 'jpeg, png, jpg, gif ပုံစံများသာ တင်ခွင့်ရှိပါသည်။',
            'image.max' => 'ဓာတ်ပုံဖိုင်ပမာဏသည် 2MB ထက် မပိုရပါ။'
        ]);

        if ($request->hasFile('image')) {
            if ($staff->image_path) {
                Storage::disk('public')->delete($staff->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('staff_images', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $staff->update($validated);

        return redirect()->back()->with('success', '၀န်ထမ်းအကောင့် ပြင်ဆင်ပြီးပါပြီ။');
    }

    public function destroy(Staff $staff)
    {
        if ($staff->image_path) {
            Storage::disk('public')->delete($staff->image_path);
        }
        $staff->delete();

        return redirect()->back()->with('success', '၀န်ထမ်းအကောင့် ဖျက်ခြင်း အောင်မြင်ပါသည်။');
    }
}
