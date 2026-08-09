<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowerLoan;
use App\Models\LoanRemainders;
use App\Models\Payement;
use App\Models\Payment;
use Carbon\Carbon;

class BorrowerLoanController extends Controller
{
    public function create()
    {
        $borrower_id = auth('borrower')->check() ? auth('borrower')->id() : '';
        $currentYear = Carbon::now()->year; // လက်ရှိနှစ် (ဥပမာ - 2026)
        $appliedSeasons = BorrowerLoan::where('borrower_id', $borrower_id)
            ->whereYear('created_at', $currentYear)
            ->whereIn('status', ['accepted', 'approved', 'rejected', 'pending']) // လိုချင်သော status များကိုသာ သီးသန့် စစ်မည်
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
            'repayment_type' => 'required|in:online,outside',
            'guarantor_name' => 'required|string|max:255',
            'tax_form_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'household_chart_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nrc_front_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nrc_back_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'guarantor_front_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'guarantor_nrc_back_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            // မြန်မာလို ပြသမည့် Error Messages များ
            'borrower_id.required' => 'ချေးငွေလျှောက်ထားသူ ID မရှိပါသဖြင့် လျှောက်ထား၍မရပါ။',
            'borrower_id.exists' => 'ဤချေးငွေလျှောက်ထားသူ ID သည် စနစ်ထဲတွင် မရှိပါ။',
            'occupation.required' => 'အလုပ်အကိုင် ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'monthly_income.required' => 'လစဉ်ဝင်ငွေ ထည့်သွင်းရန် လိုအပ်ပါသည်။',
            'monthly_income.numeric' => 'လစဉ်ဝင်ငွေကို ဂဏန်းသီးသန့်သာ ရိုက်ထည့်ပေးပါ။',
            'workplace_address.required' => 'အလုပ်နေရာ လိပ်စာ ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'acres.required' => 'စိုက်ပျိုးမည့် ဧကပမာဏ ထည့်သွင်းရန် လိုအပ်ပါသည်။',
            'acres.min' => 'ချေးငွေကို အနည်းဆုံး (၁) ဧကမှ စတင်လျှောက်ထားနိုင်ပါသည်။',
            'acres.max' => 'ချေးငွေကို အများဆုံး (၁၀) ဧကအထိသာ လျှောက်ထားနိုင်ပါသည်။',
            'season_type.required' => 'စိုက်ပျိုးမည့် ရာသီဥတုကို ရွေးချယ်ပေးပါ။',
            'atone_none.required' => 'အတိုး/အရင်း ဆပ်ရမည့်ပုံစံကို ရွေးချယ်ပေးပါ။',
            'guarantor_name.required' => 'အာမခံသူ အမည် ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'repayment_type.required' => 'ပြန်ဆပ်မည့် နည်းလမ်းကို ရွေးချယ်ပေးပါ။', // <--- ထပ်ပေါင်းထားသည်
            'repayment_type.in' => 'မှန်ကန်သော ပြန်ဆပ်မည့် နည်းလမ်းကို ရွေးချယ်ပေးပါ။',
            'tax_form_image.required' => 'ပုံစံ(၇) မူရင်းပုံ တင်ရန် လိုအပ်ပါသည်။',
            'household_chart_image.required' => 'အိမ်ထောင်စုစာရင်းပုံ တင်ရန် လိုအပ်ပါသည်။',
            'nrc_front_image.required' => 'မှတ်ပုံတင် အရှေ့ပုံ တင်ရန် လိုအပ်ပါသည်။',
            'nrc_back_image.required' => 'မှတ်ပုံတင် အနောက်ပုံ တင်ရန် လိုအပ်ပါသည်။',
            'guarantor_front_image.required' => 'အာမခံသူ မှတ်ပုံတင် အရှေ့ပုံ တင်ရန် လိုအပ်ပါသည်။',
            'guarantor_nrc_back_image.required' => 'အာမခံသူ မှတ်ပုံတင် အနောက်ပုံ တင်ရန် လိုအပ်ပါသည်။',
            '*.image' => 'တင်လိုက်သော ဖိုင်သည် ဓာတ်ပုံဖိုင် (Image) သာ ဖြစ်ရပါမည်။',
            '*.mimes' => 'ဓာတ်ပုံများသည် jpeg, png, jpg format များသာ ဖြစ်ရပါမည်။',
            '*.max' => 'ဓာတ်ပုံတစ်ပုံချင်းစီ၏ Size သည် 2MB ထက် မကျော်ရပါ။',
        ]);

        // ၂။ စည်းကမ်းချက် (၅၊ ၆) အလိုက် ငွေပမာဏ တွက်ချက်ခြင်း
        $acres = $request->acres;
        $amount_per_acre = ($request->season_type === 'rainy') ? 300000 : 250000;
        $total_amount = $acres * $amount_per_acre;

        // ၃။ သက်တမ်း ၁ နှစ် သတ်မှတ်ခြင်း (Determine dates based on season_type)
        $currentYear = \Illuminate\Support\Carbon::now()->year;

        if ($request->season_type === 'rainy') {
            // Rainy: May 1 of current year to Sep 30 of current year
            $startDate = \Illuminate\Support\Carbon::create($currentYear, 5, 1);
            $endDate = \Illuminate\Support\Carbon::create($currentYear, 9, 30);
        } else {
            // Winter/Summer: Oct 1 of current year to Jan 31 of next year
            $startDate = \Illuminate\Support\Carbon::create($currentYear, 10, 1);
            $endDate = \Illuminate\Support\Carbon::create($currentYear + 1, 1, 31);
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
        $loan->repayment_type = $request->repayment_type;


        // ဓာတ်ပုံများ သိမ်းဆည်းခြင်း
        if ($request->hasFile('tax_form_image')) {
            $loan->tax_form_image = $request->file('tax_form_image')->store('loan_documents', 'public');
        }
        if ($request->hasFile('household_chart_image')) {
            $loan->household_chart_image = $request->file('household_chart_image')->store('loan_documents', 'public');
        }
        if ($request->hasFile('nrc_front_image')) {
            $loan->nrc_front_image = $request->file('nrc_front_image')->store('loan_documents', 'public');
        }
        if ($request->hasFile('nrc_back_image')) {
            $loan->nrc_back_image = $request->file('nrc_back_image')->store('loan_documents', 'public');
        }
        // အာမခံသူ မှတ်ပုံတင်ပုံများ (Guarantor Images)
        if ($request->hasFile('guarantor_front_image')) {
            $loan->guarantor_front_image = $request->file('guarantor_front_image')->store('loan_documents', 'public');
        }
        if ($request->hasFile('guarantor_nrc_back_image')) {
            $loan->guarantor_nrc_back_image = $request->file('guarantor_nrc_back_image')->store('loan_documents', 'public');
        }

        $loan->status = 'pending';
        $loan->rejected_reason = null;
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

        if ($request->has('close_loan') && $request->close_loan == true) {
            $loan->is_closed = true;
            $loan->status = 'rejected';
            $loan->save();
            return back()->with('success', 'ချေးငွေကို အပြီးတိုင် ပိတ်သိမ်းလိုက်ပါပြီ!');
        }

        if ($request->status === 'accepted') {
            $interest = $loan->total_amount * 0.05;
            $totalRepayment = $loan->total_amount + $interest;

            $remainder = new LoanRemainders();
            $remainder->loan_id = $loan->id;
            $remainder->total_repayment_amount = $totalRepayment;
            $remainder->repayment_date = Carbon::parse($loan->created_at)->addYear();
            $remainder->save();

            $loan->status = 'accepted';
            $loan->rejected_reason = null;
        } elseif ($request->status === 'resubmitted') {
            $request->validate([
                'rejected_reason' => 'required|string',
            ], [
                'rejected_reason.required' => 'ငြင်းပယ်ရသည့် အကြောင်းအရင်းကို ဖြည့်သွင်းပေးပါ၊'
            ]);

            $loan->status = 'resubmitted';
            $loan->rejected_reason = $request->rejected_reason;
        } else {
            $loan->status = $request->status;
        }

        $loan->save();

        return back()->with('success', 'အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ!');
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

    public function showRepaymentDetail($id)
    {
        $loan = BorrowerLoan::with('loanRemainder')->findOrFail($id);
        $remainder = $loan->loanRemainder;

        $today = Carbon::today()->startOfDay();
        $repaymentDate = Carbon::parse($remainder->repayment_date)->startOfDay();

        $penalty = 0;
        $isOverdue = $today->gt($repaymentDate);

        if ($isOverdue) {
            $penalty = $remainder->total_repayment_amount * 0.05;
        }

        $netTotal = $remainder->total_repayment_amount + $penalty;

        $total = $remainder->total_repayment_amount;

        $remainder->net_total_repayment_amount = $netTotal;
        $remainder->save();

        return view('repayment_detail', compact('loan', 'remainder', 'penalty', 'netTotal', 'isOverdue', 'total'));
    }

    public function processPayment(Request $request, $id)
    {
        $loan = BorrowerLoan::with('loanRemainder')->findOrFail($id);
        $remainder = $loan->loanRemainder;

        $repaymentType = $request->input('repayment_type', $loan->repayment_type);

        $screenshotPath = null;

        if ($repaymentType === 'online') {
            $rules = [
                'payment_method'     => 'required|string',
                'transaction_id'     => 'required|string|unique:payments,transaction_id',
                'payment_screenshot' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];

            if ($request->payment_method === 'BankTransfer') {
                $rules['bank_name']           = 'required|string|max:255';
                $rules['account_number']      = 'required|string|max:255';
                $rules['account_holder_name'] = 'required|string|max:255';
            }

            $messages = [
                'payment_method.required'     => 'ကျေးဇူးပြု၍ ငွေပေးချေမှုနည်းလမ်း ရွေးချယ်ပါ။',
                'transaction_id.required'     => 'Transaction ID (လုပ်ငန်းစဉ် အမှတ်) ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
                'transaction_id.unique'       => 'ဤ Transaction ID သည် အသုံးပြုပြီးသား ဖြစ်နေပါသည်။ ပြန်လည်စစ်ဆေးပေးပါ။',
                'payment_screenshot.required' => 'ငွေလွှဲပြေစာ ဓာတ်ပုံ တင်ရန် လိုအပ်ပါသည်။',
                'payment_screenshot.image'    => 'တင်ပြသော ဖိုင်သည် ဓာတ်ပုံ အမျိုးအစား (Image) ဖြစ်ရပါမည်။',
                'payment_screenshot.mimes'    => 'ဓာတ်ပုံကို jpeg, png, jpg format များဖြင့်သာ လက်ခံပါသည်။',
                'payment_screenshot.max'      => 'ဓာတ်ပုံဖိုင် အရွယ်အစားသည် 2MB ထက် မကျော်လွန်ရပါ။',
                'bank_name.required'           => 'ဘဏ်အမည် ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
                'account_number.required'      => 'အကောင့်အမှတ် ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
                'account_holder_name.required' => 'အကောင့်ပိုင်ရှင်အမည် ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            ];

            $validated = $request->validate($rules, $messages);

            if ($request->hasFile('payment_screenshot')) {
                $screenshotPath = $request->file('payment_screenshot')->store('payments', 'public');
            }
        }

        $today = Carbon::today();
        $repaymentDate = Carbon::parse($remainder->repayment_date);

        $penalty = 0;
        if ($today->gt($repaymentDate)) {
            $penalty = $remainder->total_repayment_amount * 0.05;
        }

        $netTotalAmount = $remainder->total_repayment_amount + $penalty;

        if ($repaymentType === 'online') {
            Payment::create([
                'borrower_loan_id'    => $loan->id,
                'amount'              => $netTotalAmount,
                'payment_method'      => $request->payment_method,
                'transaction_id'      => $request->transaction_id,
                'payment_screenshot'  => $screenshotPath,
                'bank_name'           => $request->bank_name ?? null,
                'account_number'      => $request->account_number ?? null,
                'account_holder_name' => $request->account_holder_name ?? null,
            ]);
        }

        $remainder->net_total_repayment_amount = $netTotalAmount;
        $remainder->status = 'repaid';
        $remainder->save();

        return back()->with('success', 'ချေးငွေကို အောင်မြင်စွာ ပြန်လည်ပေးချေပြီးပါပြီ။');
    }

    public function loanPaidList()
    {
        $repayments = LoanRemainders::with(['borrowerLoan.borrower'])
            ->where('status', '!=', 'pending')
            ->latest()
            ->get();

        $repayments->transform(function ($item) {
            $today = now();
            $repaymentDate = \Carbon\Carbon::parse($item->repayment_date);

            $item->is_overdue = $today->greaterThan($repaymentDate);
            return $item;
        });

        return view('staff.repaid', compact('repayments'));
    }

    // BorrowerLoanController.php
    public function updateStatusReaminder(Request $request, $id)
    {
        // $id သည် LoanRemainder ၏ id ဖြစ်ရပါမည်
        $repayment = LoanRemainders::findOrFail($id);

        $repayment->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status အောင်မြင်စွာ ပြောင်းလဲပြီးပါပြီ။');
    }

    public function loanEdit($id)
    {
        $loan = BorrowerLoan::findOrFail($id);
        $borrower_id = $loan->borrower_id;
        $currentYear = date('Y');

        // pending သို့မဟုတ် resubmitted ဖြစ်မှသာ ပြင်ဆင်ခွင့်ပေးမည်
        if (!in_array($loan->status, ['pending', 'resubmitted'])) {
            return redirect()->back()->with('error', 'ဤလျှောက်လွှာကို ပြင်ဆင်ခွင့်မရှိတော့ပါ။');
        }

        $appliedSeasons = BorrowerLoan::where('borrower_id', $borrower_id)
            ->whereYear('created_at', $currentYear)
            ->whereIn('status', ['accepted', 'approved', 'rejected', 'pending']) // လိုချင်သော status များကိုသာ သီးသန့် စစ်မည်
            ->pluck('season_type')
            ->toArray();

        $hasAppliedRainy = in_array('rainy', $appliedSeasons);
        $hasAppliedWinter = in_array('winter', $appliedSeasons);

        return view('borrower.loans.edit', compact('loan', 'hasAppliedRainy', 'hasAppliedWinter'));
    }

    public function loanUpdate(Request $request, $id)
    {
        $loan = BorrowerLoan::findOrFail($id);

        $request->validate([
            'occupation' => 'required|string',
            'monthly_income' => 'required|numeric',
            'workplace_address' => 'required|string',
            'season_type' => 'required',
            'acres' => 'required|numeric|min:1|max:10',
            'guarantor_name' => 'required|string',
            'tax_form_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'household_chart_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nrc_front_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nrc_back_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'guarantor_front_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'guarantor_nrc_back_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // ပုံအသစ်တင်ခဲ့ရင် Update လုပ်မည်၊ မတင်ရင် ယခင်ပုံဟောင်းအတိုင်းထားမည်
        $imageFields = ['tax_form_image', 'household_chart_image', 'nrc_front_image', 'nrc_back_image', 'guarantor_front_image', 'guarantor_nrc_back_image'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $loan->$field = $request->file($field)->store('loan_documents', 'public');
            }
        }

        $loan->occupation = $request->occupation;
        $loan->monthly_income = $request->monthly_income;
        $loan->workplace_address = $request->workplace_address;
        $loan->season_type = $request->season_type;
        $loan->acres = $request->acres;
        $loan->total_amount = ($request->season_type === 'rainy') ? ($request->acres * 300000) : ($request->acres * 250000);
        $loan->guarantor_name = $request->guarantor_name;

        // ပြန်တင်လိုက်သည့်အတွက် status ကို pending သို့ ပြန်ပြောင်းမည်
        $loan->status = 'pending';
        $loan->rejected_reason = null;
        $loan->save();

        return redirect()->route('borrower.loan.history')->with('success', 'ချေးငွေလျှောက်လွှာ ပြန်လည်ပြင်ဆင် တင်သွင်းပြီးပါပြီ။');
    }
}
