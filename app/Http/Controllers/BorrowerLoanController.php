<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowerLoan;
use App\Models\LoanRemainders;
use Carbon\Carbon;

class BorrowerLoanController extends Controller
{
    public function create()
    {
        $borrower_id = auth('borrower')->check() ? auth('borrower')->id() : '';
        $currentYear = Carbon::now()->year; // လက်ရှိနှစ် (ဥပမာ - 2026)
        $appliedSeasons = BorrowerLoan::with(['borrower', 'loanRemainder'])
            ->where('borrower_id', $borrower_id)
            ->whereYear('created_at', $currentYear)
            ->pluck('season_type')
            ->toArray();

        $hasAppliedRainy = in_array('rainy', $appliedSeasons);
        $hasAppliedWinter = in_array('winter', $appliedSeasons);

        $hasAppliedBoth = $hasAppliedRainy && $hasAppliedWinter;

        return view('borrower.loan-form', compact('borrower_id', 'hasAppliedRainy', 'hasAppliedWinter', 'hasAppliedBoth'));
    }

    public function store(Request $request)
    {
        // ၁။ Rules များနှင့် မြန်မာလို သတိပေးစာတန်း (Messages) များကို စစ်ဆေးခြင်း
        $validated = $request->validate([
            'borrower_id' => 'required|exists:borrowers,id',
            'occupation' => 'required|string|max:255',
            'monthly_income' => 'required|numeric|min:0',
            'workplace_address' => 'required|string',
            'acres' => 'required|integer|min:1|max:10', // ၁ မှ ၁၀ ဧက
            'season_type' => 'required|in:rainy,winter',
            'loan_type' => 'required|string',
            'atone_none' => 'required|string',
            'guarantor_name' => 'required|string|max:255',
            'tax_form_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'household_chart_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nrc_front_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nrc_back_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            // မြန်မာလို ပြသမည့် Error Messages များ
            'borrower_id.required' => 'ချေးငွေလျှောက်ထားသူ ID မရှိပါသဖြင့် လျှောက်ထား၍မရပါ။',
            'borrower_id.exists' => 'ဤချေးငွေလျှောက်ထားသူ ID သည် စနစ်ထဲတွင် မရှိပါ။',
            'occupation.required' => 'အလုပ်အကိုင် ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'monthly_income.required' => 'လစဉ်ဝင်ငွေ ထည့်သွင်းရန် လိုအပ်ပါသည်။',
            'monthly_income.numeric' => 'လစဉ်ဝင်ငွေကို ဂဏန်းသီးသန့်သာ ရိုက်ထည့်ပေးပါ။',
            'workplace_address' => 'အလုပ်နေရာ လိပ်စာ ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'acres.required' => 'စိုက်ပျိုးမည့် ဧကပမာဏ ထည့်သွင်းရန် လိုအပ်ပါသည်။',
            'acres.min' => 'ချေးငွေကို အနည်းဆုံး (၁) ဧကမှ စတင်လျှောက်ထားနိုင်ပါသည်။',
            'acres.max' => 'ချေးငွေကို အများဆုံး (၁၀) ဧကအထိသာ လျှောက်ထားနိုင်ပါသည်။',
            'season_type.required' => 'စိုက်ပျိုးမည့် ရာသီဥတုကို ရွေးချယ်ပေးပါ။',
            'atone_none.required' => 'အတိုး/အရင်း ဆပ်ရမည့်ပုံစံကို ရွေးချယ်ပေးပါ။',
            'guarantor_name.required' => 'အာမခံသူ အမည် ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'tax_form_image.required' => 'ပုံစံခွန် မူရင်းပုံ တင်ရန် လိုအပ်ပါသည်။',
            'household_chart_image.required' => 'အိမ်ထောင်စုစာရင်းပုံ တင်ရန် လိုအပ်ပါသည်။',
            'nrc_front_image.required' => 'မှတ်ပုံတင် အရှေ့ပုံ တင်ရန် လိုအပ်ပါသည်။',
            'nrc_back_image.required' => 'မှတ်ပုံတင် အနောက်ပုံ တင်ရန် လိုအပ်ပါသည်။',
            '*.image' => 'တင်လိုက်သော ဖိုင်သည် ဓာတ်ပုံဖိုင် (Image) သာ ဖြစ်ရပါမည်။',
            '*.mimes' => 'ဓာတ်ပုံများသည် jpeg, png, jpg format များသာ ဖြစ်ရပါမည်။',
            '*.max' => 'ဓာတ်ပုံတစ်ပုံချင်းစီ၏ Size သည် 2MB ထက် မကျော်ရပါ။',
        ]);

        // ၂။ စည်းကမ်းချက် (၅၊ ၆) အလိုက် ငွေပမာဏ တွက်ချက်ခြင်း
        $acres = $request->acres;
        $amount_per_acre = ($request->season_type === 'rainy') ? 300000 : 250000;
        $total_amount = $acres * $amount_per_acre;

        // ၃။ သက်တမ်း ၁ နှစ် သတ်မှတ်ခြင်း
        // Determine dates based on season_type
        $currentYear = Carbon::now()->year;

        if ($request->season_type === 'rainy') {
            // Rainy: May 1 of current year to Sep 30 of current year
            $startDate = Carbon::create($currentYear, 5, 1);
            $endDate = Carbon::create($currentYear, 9, 30);
        } else {
            $startDate = Carbon::create($currentYear, 10, 1);
            $endDate = Carbon::create($currentYear + 1, 1, 31);
        }

        // ၄။ Database ထဲသို့ သိမ်းဆည်းခြင်း
        $loan = new BorrowerLoan();
        $loan->borrower_id = $request->borrower_id;
        $loan->saving_account_number = $request->borrower_id;
        $loan->occupation = $request->occupation;
        $loan->monthly_income = $request->monthly_income;
        $loan->workplace_address = $request->workplace_address;
        $loan->acres = $acres;
        $loan->season_type = $request->season_type;
        $loan->loan_type = $request->loan_type;
        $loan->loan_limit = 10.00;
        $loan->rate = 5.00;
        $loan->total_amount = $total_amount;
        $loan->atone_none = $request->atone_none;
        $loan->loan_start_date = $startDate->format('Y-m-d');
        $loan->loan_end_date = $endDate->format('Y-m-d');
        $loan->guarantor_name = $request->guarantor_name;

        if ($request->hasFile('tax_form_image'))
            $loan->tax_form_image = $request->file('tax_form_image')->store('loan_documents', 'public');
        if ($request->hasFile('household_chart_image'))
            $loan->household_chart_image = $request->file('household_chart_image')->store('loan_documents', 'public');
        if ($request->hasFile('nrc_front_image'))
            $loan->nrc_front_image = $request->file('nrc_front_image')->store('loan_documents', 'public');
        if ($request->hasFile('nrc_back_image'))
            $loan->nrc_back_image = $request->file('nrc_back_image')->store('loan_documents', 'public');

        $loan->status = 'pending';
        $loan->save();

        return redirect()->route('borrower.loan')->with('success', 'ချေးငွေလျှောက်လွှာ တင်သွင်းမှု အောင်မြင်ပါသည်။ လူကြီးမင်း၏ လျှောက်လွှာကို စနစ်မှ စိစစ်နေပါသည်။');
    }

    public function history()
    {
        $borrower_id = auth('borrower')->check() ? auth('borrower')->id() : '';

        $loans = BorrowerLoan::with(['borrower', 'loanRemainder'])
            ->where('borrower_id', $borrower_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('borrower.loan-history', compact('loans'));
    }

    // BorrowerLoanController.php
    public function index()
    {
        $loans = BorrowerLoan::with(['borrower', 'loanRemainder'])->get();
        return view('staff.loan', compact('loans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $loan = BorrowerLoan::findOrFail($id);

        if ($request->status === 'accepted') {

            $interest = $loan->total_amount * 0.05;
            $totalRepayment = $loan->total_amount + $interest;

            $remainder = new LoanRemainders();
            $remainder->loan_id = $loan->id;
            $remainder->total_repayment_amount = $totalRepayment;

            $remainder->repayment_date = Carbon::parse($loan->created_at)->addYear();

            $remainder->save();
        }

        $loan->status = $request->status;
        $loan->save();

        return back()->with('success', 'အောင်မြင်စွာ ပြင်ဆင်ပီးပါပီ!');
    }

    public function processRepayment(Request $request, $loanId)
    {
        $loan = BorrowerLoan::findOrFail($loanId);
        $remainder = $loan->loanRemainder;

        if (!$remainder) {
            return back()->with('error', 'ချေးငွေအချက်အလက် မတွေ့ရှိပါ။');
        }

        $totalAmount = $remainder->total_repayment_amount;

        if (\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($remainder->repayment_date))) {
            $penalty = $totalAmount * 0.05;
            $totalAmount += $penalty;
        }

        $remainder->net_total_repayment_amount = $totalAmount;
        $remainder->status = 'repaid';
        $remainder->save();

        return back()->with('success', 'ငွေပေးချေမှု အောင်မြင်ပါသည်။ ပေးသွင်းငွေမှာ ' . number_format($totalAmount) . ' ကျပ် ဖြစ်ပါသည်။');
    }
}
