<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Borrower;
use App\Models\BorrowerLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Complaint;
use App\Mail\ComplaintReplyMail;
use App\Mail\ComplaintSubmittedMail;
use App\Models\Staff;
use Illuminate\Support\Facades\Mail;

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
        $user = auth()->user();
        // Validate inputs with your exact custom regex rules
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?!.*[0-9\x{1040}-\x{1049}]).*$/u'
            ],
            'email' => 'required|email|unique:staff,email,' . $user->id,
            'phone' => [
                'required',
                'string',
                'max:15',
                'regex:/^(09|\+?959|၀၉|\+?၉၅၉)[0-9\x{1040}-\x{1049}]{7,9}$/u'
            ],
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            // Name Messages
            'name.required' => 'အမည် ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
            'name.string' => 'အမည်သည် စာသား ဖြစ်ရပါမည်။',
            'name.max' => 'အမည်သည် စာလုံးရေ ၂၅၅ လုံးထက် မကျော်လွန်ရပါ။',
            'name.regex' => 'အမည်တွင် ကိန်းဂဏန်းများ ထည့်သွင်း၍ မရပါ။',

            // Email Messages
            'email.required' => 'အီးမေးလ် ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
            'email.email' => 'မှန်ကန်သော အီးမေးလ် ပုံစံ ဖြစ်ရပါမည်။',
            'email.unique' => 'ဤ အီးမေးလ်သည် အသုံးပြုပြီးသား ဖြစ်နေပါသည်။',

            // Phone Messages
            'phone.required' => 'ဖုန်းနံပါတ် ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
            'phone.max' => 'ဖုန်းနံပါတ်သည် ၁၅ လုံးထက် မကျော်လွန်ရပါ။',
            'phone.regex' => 'မှန်ကန်သော မြန်မာဖုန်းနံပါတ် ပုံစံ ဖြစ်ရပါမည်။',

            // Address Messages
            'address.string' => 'လိပ်စာသည် စာသား ဖြစ်ရပါမည်။',

            // Password Messages
            'password.min' => 'စကားဝှက်သည် အနည်းဆုံး ၆ လုံး ရှိရပါမည်။',

            // Profile Image Messages
            'profile_image.image' => 'ဓါတ်ပုံ ဖိုင်အမျိုးအစား သာ ဖြစ်ရပါမည်။',
            'profile_image.mimes' => 'ဓါတ်ပုံသည် jpeg, png, jpg, gif အမျိုးအစားများသာ ဖြစ်ရပါမည်။',
            'profile_image.max' => 'ဓါတ်ပုံ ဖိုင်ဆိုဒ်သည် 2MB ထက် မကျော်လွန်ရပါ။',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        // Only update password if a new one is provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle profile image update if present
        if ($request->hasFile('profile_image')) {
            if ($user->image_path) {
                Storage::disk('public')->delete($user->image_path);
            }

            $path = $request->file('profile_image')->store('profile_images', 'public');
            $data['image_path'] = $path;
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'ပရိုဖိုင် အချက်အလက်များ အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။'
        ]);
    }

    public function create()
    {
        // Get the first staff member with role 'admin'
        $adminStaff = Staff::where('role', 'admin')->first();
        $adminEmail = $adminStaff ? $adminStaff->email : 'admin@example.com';

        return view('complaint.create', compact('adminEmail'));
    }

    /**
     * Store and send complaint mail.
     */
    public function store(Request $request)
    {
        // Retrieve currently logged-in borrower
        $borrower = Auth::guard('borrower')->user();

        // Get the first staff/admin email fallback
        $adminStaff = Staff::first();
        $adminEmail = $adminStaff ? $adminStaff->email : 'admin@example.com';

        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ], [
            'subject.required' => 'ခေါင်းစဉ် ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
            'body.required' => 'အကြောင်းအရာ ဖြည့်သွင်းရန် လိုအပ်ပါသည်။',
            'images.*.image' => 'ဓါတ်ပုံ ဖိုင်အမျိုးအစား သာ ဖြစ်ရပါမည်။',
            'images.*.max' => 'ပုံတစ်ပုံလျှင် 4MB ထက် မကျော်လွန်ရပါ။',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('complaint_images', 'public');
            }
        }

        // Save Complaint with Auto-filled Emails
        $complaint = Complaint::create([
            'borrower_id' => $borrower ? $borrower->id : null,
            'from_email' => $borrower ? $borrower->email : $request->input('from_email'),
            'to_email' => $adminEmail,
            'subject' => $request->subject,
            'body' => $request->body,
            'images' => $imagePaths,
        ]);

        // Send Email
        try {
            Mail::to($complaint->to_email)->send(new ComplaintSubmittedMail($complaint));
        } catch (\Exception $e) {
            \Log::error('Complaint Mail Failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'တိုင်ကြားစာ အောင်မြင်စွာ ပေးပို့ပြီးပါပြီ။');
    }

    public function index()
    {
        $complaints = Complaint::with('borrower')->latest()->paginate(10);
        return view('staff.complaints.index', compact('complaints'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,resolved,rejected',
            'reply_note' => 'nullable|string',
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->status = $request->status;
        $complaint->save();

        // Reverse Emails: Original DB 'from_email' (Borrower) becomes recipient 'to_email'
        $replyToEmail = $complaint->from_email;
        $replyFromEmail = $complaint->to_email;   // Staff / Admin Email

        // Send Email Back to Borrower
        try {
            Mail::to($replyToEmail)->send(new ComplaintReplyMail(
                $complaint,
                $request->reply_note,
                $request->status,
                $replyFromEmail
            ));
        } catch (\Exception $e) {
            \Log::error('Reply Mail Error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'တိုင်ကြားစာ အခြေအနေ ပြောင်းလဲ၍ အီးမေးလ် အကြောင်းပြန်ပြီးပါပြီ။');
    }
}
