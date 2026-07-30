@extends('layouts.app')

@section('content')

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

            <div class="bg-amber-600 p-6 text-white text-center">
                <h2 class="text-2xl font-bold">စိုက်ပျိုးစရိတ် ချေးငွေလျှောက်လွှာ ပြန်လည်ပြင်ဆင်ခြင်း</h2>
                <p class="text-sm text-amber-100 mt-1">လိုအပ်သောအချက်အလက်များကို ပြင်ဆင်ပြီး ပြန်လည်တင်သွင်းပေးပါရန်</p>
            </div>

            @if($loan->rejected_reason)
                <div class="m-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg font-medium">
                    ⚠️ <b>ငြင်းပယ်ခဲ့သည့် အကြောင်းအရင်း:</b> {{ $loan->rejected_reason }}
                </div>
            @endif

            <form action="{{ route('borrower.loans.update', $loan->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <fieldset>

                    <div class="border-b border-gray-100 pb-5 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 text-amber-600">၁။ အလုပ်အကိုင်နှင့် ကိုယ်ရေးအချက်အလက်</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">ချေးငွေလျှောက်ထားသူ ကုဒ်နံပါတ် (Borrower ID)</label>
                                <input type="text" value="{{ $loan->borrower_id }}" readonly
                                    class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-gray-700 font-bold cursor-not-allowed">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">အလုပ်အကိုင် (Occupation)</label>
                                <input type="text" name="occupation" value="{{ old('occupation', $loan->occupation) }}" required
                                    class="w-full border @error('occupation') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                                @error('occupation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">လစဉ်ဝင်ငွေ (Monthly Income)</label>
                                <input type="number" name="monthly_income" value="{{ old('monthly_income', $loan->monthly_income) }}" required
                                    class="w-full border @error('monthly_income') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                                @error('monthly_income') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">အလုပ်နေရာ လိပ်စာ (Workplace Address)</label>
                                <textarea name="workplace_address" rows="2" required
                                    class="w-full border @error('workplace_address') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('workplace_address', $loan->workplace_address) }}</textarea>
                                @error('workplace_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-b border-gray-100 pb-5 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 text-amber-600">၂။ ချေးငွေဆိုင်ရာ အချက်အလက်များ</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">စိုက်ပျိုးမည့် ရာသီဥတု (Season Type)</label>
    <select name="season_type" id="season_type" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">

        <!-- မိုးသီးနှံ option (အခြား record မှာ မိုးသီးနှံ လျှောက်ပြီးသားဖြစ်နေရင် disable လုပ်မည်) -->
        <option value="rainy"
            {{ old('season_type', $loan->season_type) == 'rainy' ? 'selected' : '' }}
            {{ $hasAppliedRainy ? 'disabled' : '' }}>
            မိုးသီးနှံ (၁ ဧက - ၃ သိန်း) {{ $hasAppliedRainy ? '(လျှောက်ထားပြီး)' : '' }}
        </option>

        <!-- ဆောင်းသီးနှံ option (အခြား record မှာ ဆောင်းသီးနှံ လျှောက်ပြီးသားဖြစ်နေရင် disable လုပ်မည်) -->
        <option value="winter"
            {{ old('season_type', $loan->season_type) == 'winter' ? 'selected' : '' }}
            {{ $hasAppliedWinter ? 'disabled' : '' }}>
            ဆောင်းသီးနှံ (၁ ဧက - ၂ သိန်းခွဲ) {{ $hasAppliedWinter ? '(လျှောက်ထားပြီး)' : '' }}
        </option>

    </select>
    @error('season_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">စိုက်ပျိုးမည့် ဧကပမာဏ (Limit: 1 - 10 ဧက)</label>
                                <input type="number" name="acres" id="acres" min="1" max="10" value="{{ old('acres', $loan->acres) }}"
                                    required class="w-full border @error('acres') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                                @error('acres') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-4 bg-gray-50 rounded-xl p-4 grid grid-cols-2 gap-4 border border-dashed border-gray-200">
                            <div>
                                <p class="text-xs text-gray-500">သတ်မှတ်အတိုးနှုန်း</p>
                                <p class="text-lg font-bold text-gray-800">5 %</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">ခန့်မှန်းရရှိမည့် စုစုပေါင်းချေးငွေ</p>
                                <p class="text-lg font-bold text-amber-600" id="display_total">{{ number_format($loan->total_amount) }} ကျပ်</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-b border-gray-100 pb-5 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 text-amber-600">၃။ အာမခံသူ အချက်အလက်/h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">အာမခံသူ အမည်</label>
                            <input type="text" name="guarantor_name" value="{{ old('guarantor_name', $loan->guarantor_name) }}" required
                                class="w-full border @error('guarantor_name') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                            @error('guarantor_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 text-amber-600">၄။ ဓာတ်ပုံများ (ပြန်လည်ပြင်ဆင်လိုမှသာ အသစ်ပြန်တင်ပါ)</h3>
                        <p class="text-xs text-gray-500 mb-4">* ပုံအသစ်မတင်ပါက ယခင်တင်ထားသော ပုံများကိုသာ ဆက်လက်အသုံးပြုပါမည်။</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <!-- Tax Form -->
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">ပုံစံ(၇) မူရင်းပုံ</label>
                                @if($loan->tax_form_image)
                                    <img src="/storage/{{ $loan->tax_form_image }}" class="h-80 w-80 rounded mb-2 border">
                                @endif
                                <input type="file" name="tax_form_image" class="block w-full text-xs text-gray-500">
                            </div>

                            <!-- Household Chart -->
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">အိမ်ထောင်စုစာရင်းပုံ</label>
                                @if($loan->household_chart_image)
                                    <img src="/storage/{{ $loan->household_chart_image }}" class="h-80 w-80 rounded mb-2 border">
                                @endif
                                <input type="file" name="household_chart_image" class="block w-full text-xs text-gray-500">
                            </div>

                            <!-- NRC Front -->
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">မှတ်ပုံတင် အရှေ့ပုံ</label>
                                @if($loan->nrc_front_image)
                                    <img src="/storage/{{ $loan->nrc_front_image }}" class="h-80 w-80 rounded mb-2 border">
                                @endif
                                <input type="file" name="nrc_front_image" class="block w-full text-xs text-gray-500">
                            </div>

                            <!-- NRC Back -->
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">မှတ်ပုံတင် အနောက်ပုံ</label>
                                @if($loan->nrc_back_image)
                                    <img src="/storage/{{ $loan->nrc_back_image }}" class="h-80 w-80 rounded mb-2 border">
                                @endif
                                <input type="file" name="nrc_back_image" class="block w-full text-xs text-gray-500">
                            </div>

                            <!-- Guarantor NRC Front -->
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">အာမခံသူ မှတ်ပုံတင် အရှေ့ပုံ</label>
                                @if($loan->guarantor_front_image)
                                    <img src="/storage/{{ $loan->guarantor_front_image }}" class="h-80 w-80 rounded mb-2 border">
                                @endif
                                <input type="file" name="guarantor_front_image" class="block w-full text-xs text-gray-500">
                            </div>

                            <!-- Guarantor NRC Back -->
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">အာမခံသူ မှတ်ပုံတင် အနောက်ပုံ</label>
                                @if($loan->guarantor_nrc_back_image)
                                    <img src="/storage/{{ $loan->guarantor_nrc_back_image }}" class="h-80 w-80 rounded mb-2 border">
                                @endif
                                <input type="file" name="guarantor_nrc_back_image" class="block w-full text-xs text-gray-500">
                            </div>

                        </div>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <a href="{{ route('borrower.loan.history') }}" class="w-1/3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-4 rounded-xl text-center transition">
                            မလုပ်တော့ပါ
                        </a>
                        <button type="submit" class="w-2/3 bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition">
                            ပြန်လည်ပြင်ဆင် တင်သွင်းမည်
                        </button>
                    </div>

                </fieldset>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const seasonSelect = document.getElementById('season_type');
            const acresInput = document.getElementById('acres');
            const displayTotal = document.getElementById('display_total');

            function calculateLoan() {
                const acres = parseInt(acresInput.value) || 0;
                const pricePerAcre = (seasonSelect.value === 'rainy') ? 300000 : 250000;
                const total = acres * pricePerAcre;
                displayTotal.innerText = total.toLocaleString() + " ကျပ်";
            }

            if (seasonSelect && acresInput) {
                seasonSelect.addEventListener('change', calculateLoan);
                acresInput.addEventListener('input', calculateLoan);
                calculateLoan();
            }
        });
    </script>
@endsection
