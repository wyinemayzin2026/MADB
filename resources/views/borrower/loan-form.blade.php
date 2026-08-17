@extends('layouts.app')

@section('content')
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

            <div class="bg-green-600 p-6 text-white text-center">
                <h2 class="text-2xl font-bold">စိုက်ပျိုးစရိတ် ချေးငွေလျှောက်လွှာပုံစံ</h2>
                <p class="text-sm text-green-100 mt-1">မှန်ကန်စွာ ဖြည့်စွက်ပေးပါရန်</p>
            </div>

            @if(session('success'))
                <div class="m-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg font-medium">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if($hasAppliedBoth)
                <div class="m-6 p-5 bg-red-50 border border-red-200 text-red-800 rounded-xl flex items-start space-x-3">
                    <span class="text-xl">🛑</span>
                    <div class="w-full">
                        <p class="font-bold text-base">ယခုနှစ်အတွက် ချေးငွေလျှောက်ထားခွင့် ကုန်ဆုံးပါပြီ</p>
                        <p class="text-sm mt-1 text-red-700">
                            လေးစားအပ်ပါသော မိဘပြည်သူတောင်သူဦးကြီးခင်ဗျာ... လူကြီးမင်းသည် ယခုနှစ် ({{ Carbon\Carbon::now()->year }}) အတွက် မိုးသီးနှံ ကော ဆောင်း/နွေသီးနှံ အတွက်ပါ ချေးငွေ (၂) ကြိမ်စလုံး လျှောက်ထားပြီးဖြစ်ပါသဖြင့် ယခုနှစ်အတွင်း ထပ်မံလျှောက်ထားခွင့် မရှိတော့ပါ။ ယခုတင်ထားသော လျှောက်လွှာများ၏ အခြေအနေကို မှတ်တမ်းတွင် ဆက်လက်စောင့်ဆိုင်း စစ်ဆေးနိုင်ပါသည်။
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('borrower.loan.history') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition text-sm">
                                📜 မိမိ၏ လျှောက်လွှာရာဇဝင်ကို ကြည့်မည်
                            </a>
                        </div>
                    </div>
                </div>
            @else

                @if($hasAppliedRainy)
                    <div class="m-6 p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-sm flex justify-between items-center">
                        <div>
                            💡 **အသိပေးချက်:** လူကြီးမင်းသည် ယခုနှစ်အတွက် **မိုးသီးနှံချေးငွေ လျှောက်ထားပြီးဖြစ်သောကြောင့်** ယခုတစ်ကြိမ်တွင် **ဆောင်း/နွေသီးနှံ အတွက်သာ** လျှောက်ထားနိုင်ပါတော့သည်။ (မိုးအတွက် ၂ ကြိမ် တင်ခွင့်မရှိပါ)
                        </div>
                        <a href="{{ route('borrower.loan.history') }}" class="text-xs bg-amber-200 hover:bg-amber-300 text-amber-900 font-bold py-1 px-2 rounded ml-2 whitespace-nowrap">ရာဇဝင်ကြည့်ရန်</a>
                    </div>
                @endif

                <form action="{{ route('borrower.loan.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                    @csrf

                    <fieldset>

                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-amber-800 text-sm space-y-1 mb-6">
                            <p class="font-bold">⚠️ ချေးငွေဆိုင်ရာ စည်းကမ်းချက်များ -</p>
                            <p>• ချေးငွေလျှောက်ထားရန် ပထမဆုံး ငွေစုစာရင်း ဖွင့်လှစ်ပြီးသူ ဖြစ်ရမည်။</p>
                            <p>• အနည်းဆုံး ၁ ဧက မှ အများဆုံး ၁၀ ဧက အထိသာ လျှောက်ထားနိုင်သည်။</p>
                            <p>• ချေးငွေသက်တမ်းမှာ စတင်ချေးသည့်နေ့မှစ၍ (၁) နှစ် တိတိ ဖြစ်သည်။ (အတိုးနှုန်း ၅%)</p>
                        </div>

                        <!-- 1. Occupation & Personal Info -->
                        <div class="border-b border-gray-100 pb-5 mb-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 text-green-600">၁။ အလုပ်အကိုင်နှင့် ကိုယ်ရေးအချက်အလက်</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">ချေးငွေလျှောက်ထားသူ ကုဒ်နံပါတ်</label>
                                    <input type="text" name="borrower_id" value="{{ $borrower_id }}" readonly
                                        class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-gray-700 font-bold cursor-not-allowed">
                                    @error('borrower_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">အလုပ်အကိုင်</label>
                                    <input type="text" name="occupation" value="{{ old('occupation') }}" required
                                        class="w-full border @error('occupation') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="ဥပမာ - လယ်သမား">
                                    @error('occupation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">လစဉ်ဝင်ငွေ</label>
                                    <input type="number" name="monthly_income" value="{{ old('monthly_income') }}" required
                                        class="w-full border @error('monthly_income') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="ကျပ်">
                                    @error('monthly_income') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">အလုပ်နေရာ လိပ်စာ</label>
                                    <textarea name="workplace_address" rows="2" required
                                        class="w-full border @error('workplace_address') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="လုပ်ကိုင်သည့် လယ်/ယာ တည်နေရာ လိပ်စာအပြည့်အစုံ">{{ old('workplace_address') }}</textarea>
                                    @error('workplace_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 2. Loan Details -->
                        <div class="border-b border-gray-100 pb-5 mb-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 text-green-600">၂။ ချေးငွေဆိုင်ရာ အချက်အလက်များ</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">ချေးငွေအမျိုးအစား</label>
                                    <input type="text" name="loan_type" value="စိုက်ပျိုးစရိတ်ချေးငွေ" readonly
                                        class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-gray-600 font-medium cursor-not-allowed">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">အတိုး/အရင်း ဆပ်ရမည့်ပုံစံ</label>
                                    <select name="atone_none" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                                        <option value="နှစ်ချုပ်စနစ်" {{ old('atone_none') == 'နှစ်ချုပ်စနစ်' ? 'selected' : '' }}>နှစ်ချုပ်စနစ် (၁ နှစ်ပြည့်မှ အတိုးအရင်းဆပ်)</option>
                                    </select>
                                    @error('atone_none') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">စိုက်ပျိုးမည့် ရာသီဥတု</label>
                                    <select name="season_type" id="season_type" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                                        <option value="rainy" @if($hasAppliedRainy) disabled class=" bg-gray-100" @endif {{ old('season_type') == 'rainy' ? 'selected' : '' }}>
                                            မိုးသီးနှံ (၁ ဧက - ၃ သိန်း) @if($hasAppliedRainy) [ယခုနှစ်အတွက် လျှောက်ပြီးသား] @endif
                                        </option>
                                        <option value="winter" @if($hasAppliedWinter) disabled class=" bg-gray-100" @endif {{ old('season_type') == 'winter' ? 'selected' : '' }}>
                                            ဆောင်းသီးနှံ (၁ ဧက - ၂ သိန်းခွဲ) @if($hasAppliedWinter) [ယခုနှစ်အတွက် လျှောက်ပြီးသား] @endif
                                        </option>
                                    </select>
                                    @error('season_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">စိုက်ပျိုးမည့် ဧကပမာဏ (1 - 10 ဧက)</label>
                                    <input type="number" name="acres" id="acres" min="1" max="10" value="{{ old('acres', 1) }}"
                                        required class="w-full border @error('acres') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                                    @error('acres') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="mt-4 bg-gray-50 rounded-xl p-4 grid grid-cols-2 gap-4 border border-dashed border-gray-200">
                                <div>
                                    <p class="text-xs text-gray-500">သတ်မှတ်အတိုးနှုန်း</p>
                                    <p class="text-lg font-bold text-gray-800">၅ %</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">ခန့်မှန်းရရှိမည့် စုစုပေါင်းချေးငွေ</p>
                                    <p class="text-lg font-bold text-green-600" id="display_total">300,000 ကျပ်</p>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Guarantor Info -->
                        <div class="border-b border-gray-100 pb-5 mb-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 text-green-600">၃။ အာမခံသူ အချက်အလက်</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">အာမခံသူ အမည် (ရွာလူကြီး / ကော်မတီဝင်)</label>
                                <input type="text" name="guarantor_name" value="{{ old('guarantor_name') }}" required
                                    class="w-full border @error('guarantor_name') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none"
                                    placeholder="အာမခံထောက်ခံမည့်သူ၏ အမည် အပြည့်အစုံ ဖြည့်ပါ">
                                @error('guarantor_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- 4. Required Documents -->
                        <div class="border-b border-gray-100 pb-5 mb-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 text-green-600">၄။ လိုအပ်သော စာရွက်စာတမ်း ဓာတ်ပုံများ တင်ရန်</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                <div class="bg-gray-50 p-4 rounded-xl border @error('tax_form_image') border-red-500 bg-red-50 @else border-gray-200 @enderror">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">ပုံစံ(၇) မူရင်းပုံ </label>
                                    <input type="file" name="tax_form_image" required
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    @error('tax_form_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="bg-gray-50 p-4 rounded-xl border @error('household_chart_image') border-red-500 bg-red-50 @else border-gray-200 @enderror">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">အိမ်ထောင်စုစာရင်းပုံ </label>
                                    <input type="file" name="household_chart_image" required
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    @error('household_chart_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="bg-gray-50 p-4 rounded-xl border @error('nrc_front_image') border-red-500 bg-red-50 @else border-gray-200 @enderror">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">မှတ်ပုံတင် အရှေ့ပုံ</label>
                                    <input type="file" name="nrc_front_image" required
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    @error('nrc_front_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="bg-gray-50 p-4 rounded-xl border @error('nrc_back_image') border-red-500 bg-red-50 @else border-gray-200 @enderror">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">မှတ်ပုံတင် အနောက်ပုံ </label>
                                    <input type="file" name="nrc_back_image" required
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    @error('nrc_back_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="bg-gray-50 p-4 rounded-xl border @error('guarantor_front_image') border-red-500 bg-red-50 @else border-gray-200 @enderror">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">အာမခံသူ မှတ်ပုံတင် အရှေ့ပုံ </label>
                                    <input type="file" name="guarantor_front_image" required
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    @error('guarantor_front_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="bg-gray-50 p-4 rounded-xl border @error('guarantor_nrc_back_image') border-red-500 bg-red-50 @else border-gray-200 @enderror">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">အာမခံသူ မှတ်ပုံတင် အနောက်ပုံ</label>
                                    <input type="file" name="guarantor_nrc_back_image" required
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    @error('guarantor_nrc_back_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                            </div>
                        </div>

                        <!-- 5. Repayment Type (NEW SECTION) -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 text-green-600">၅။ ပြန်ဆပ်မည့် နည်းလမ်း</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ပြန်ဆပ်မည့် အမျိုးအစား ရွေးချယ်ပါ</label>
                                <select name="repayment_type" required class="w-full border @error('repayment_type') border-red-500 @else border-gray-300 @enderror rounded-lg p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                                    <option value="online" {{ old('repayment_type') == 'online' ? 'selected' : '' }}>အွန်လိုင်းမှ ပြန်ဆပ်မည် </option>
                                    <option value="outside" {{ old('repayment_type') == 'outside' ? 'selected' : '' }}>ဘဏ်သို့ လာရောက် ဆပ်မည်</option>
                                </select>
                                @error('repayment_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition duration-200 hover:-translate-y-0.5">
                                ချေးငွေလျှောက်လွှာ တင်သွင်းမည်
                            </button>
                        </div>

                    </fieldset>
                </form>
            @endif

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const seasonSelect = document.getElementById('season_type');
            const acresInput = document.getElementById('acres');
            const displayTotal = document.getElementById('display_total');

            if (seasonSelect && seasonSelect.options[seasonSelect.selectedIndex].disabled) {
                for (let i = 0; i < seasonSelect.options.length; i++) {
                    if (!seasonSelect.options[i].disabled) {
                        seasonSelect.selectedIndex = i;
                        break;
                    }
                }
            }

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
