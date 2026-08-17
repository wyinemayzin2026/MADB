@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow-xl rounded-2xl border border-gray-100">
        <!-- ခေါင်းစဉ် -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">ငွေပေးချေမှု အချက်အလက်</h2>
            <p class="text-sm text-gray-500 mt-1">
                ပေးချေမှုအမျိုးအစား -
                <span class="font-semibold text-blue-600">
                    {{ ($loan->repayment_type ?? 'online') === 'online' ? 'အွန်လိုင်းမှ ပေးချေမှု' : 'အပြင်တွင် တိုက်ရိုက်ပေးချေမှု (Outside)' }}
                </span>
            </p>
        </div>

        <!-- ၁။ ငွေပေးချေရမည့် ပမာဏ တွက်ချက်မှုပြကွက် -->
        <div class="bg-gray-50 p-5 rounded-xl space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">မူရင်းငွေ</span>
                <span class="font-semibold text-gray-900">
                    {{ str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'], number_format($loan->total_amount)) }} ကျပ်
                </span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-gray-600">အတိုး ၅%</span>
                <span class="font-semibold text-gray-900">
                    {{ str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'], number_format($loan->total_amount * 0.05)) }} ကျပ်
                </span>
            </div>

            {{-- ရက်လွန်နေပါက ရက်လွန်သွားသော လ အရေအတွက်ပါ ပြသမည် --}}
            @if($isOverdue)
                <div class="flex justify-between items-center text-red-600">
                    <span class="font-bold flex items-center gap-2">
                        <span>ရက်လွန်ဒဏ်ကြေး</span>
                        <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-semibold">
    ({{ str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'], round($monthsOverdue)) }} လ)
</span>
                    </span>
                    <span class="font-bold">
                        + {{ str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'], number_format($penalty)) }} ကျပ်
                    </span>
                </div>
            @endif

            <div class="border-t border-gray-200 pt-4 mt-2">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-gray-800">စုစုပေါင်းပေးရန်</span>
                    <span class="text-2xl font-black text-green-700">
                        {{ str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'], number_format($netTotal)) }} ကျပ်
                    </span>
                </div>
            </div>
        </div>

        <!-- ၂။ ငွေပေးချေမှု Form -->
        <form action="{{ route('loan.repay.process', $loan->id) }}" method="POST" enctype="multipart/form-data" class="mt-8">
            @csrf

            <!-- Controller သို့ Repayment Type ပို့ရန် -->
            <input type="hidden" name="repayment_type" value="{{ $loan->repayment_type ?? 'online' }}">

            @if($remainder->status === 'pending' || $remainder->status === 'rejected')

                @if($remainder->status === 'rejected')
                    <div class="bg-red-50 p-4 rounded-xl text-center space-y-2 border border-red-200 mb-6">
                        <div class="text-3xl">❌</div>
                        <p class="text-red-700 font-bold">ပေးချေမှု ပယ်ချခံထားရသည်</p>
                        <p class="text-sm text-red-600">
                            {{ $remainder->rejected_reason ?? 'ဘဏ်မှ သင်၏ပေးချေမှုကို အတည်မပြုပါ။ အချက်အလက်များ ပြန်လည်စစ်ဆေးပြီး ပြန်လည်လုပ်ဆောင်ပါ။' }}
                        </p>
                    </div>
                @endif

                <!-- Online Repayment ဖြစ်မှသာ Payment Fields များ ပြမည် -->
                @if(($loan->repayment_type ?? 'online') === 'online')

                    <!-- ငွေပေးချေမှုနည်းလမ်း ရွေးချယ်ရန် -->
                    <div class="mb-6 mt-6">
                        <label class="font-semibold text-gray-700 mb-3 block">ငွေပေးချေမှုနည်းလမ်း ရွေးချယ်ပါ</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                            @foreach(['KBZ Pay', 'WAVE Pay', 'CB Pay', 'AYA Pay', 'OKDollor', 'uabpay', 'CTZ Pay', 'BankTransfer'] as $index => $method)
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_method" value="{{ $method }}" class="peer sr-only"
                                        onchange="togglePaymentFields(this.value)" {{ old('payment_method') == $method ? 'checked' : '' }}>
                                    <div class="p-2 border-2 rounded-2xl peer-checked:border-blue-600 peer-checked:bg-blue-50 text-center transition hover:border-gray-300">
                                        <img src="{{ asset('assets/img/payment/' . ($index + 1) . '.png') }}" alt="{{ $method }}" class="h-8 mx-auto mb-2 object-contain">
                                        <span class="text-xs font-bold block truncate">{{ $method }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Detail Fields Section -->
                    <div id="paymentDetailsSection" class="space-y-4 mb-6 hidden">

                        <!-- BankTransfer ရွေးချယ်မှသာ ပေါ်လာမည့် ဘဏ်အကောင့်အချက်အလက်များ -->
                        <div id="bankDetailsSection" class="p-4 bg-gray-50 border border-gray-200 rounded-xl space-y-3 hidden">
                            <h4 class="font-bold text-gray-700 text-sm border-b pb-2">ဘဏ်အကောင့် အချက်အလက်များ</h4>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ဘဏ်အမည်</label>
                                <input type="text" name="bank_name" value="{{ old('bank_name') }}"
                                    placeholder="ဥပမာ - KBZ Bank, CB Bank, AYA Bank"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                                @error('bank_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">အကောင့်အမှတ်</label>
                                <input type="text" name="account_number" value="{{ old('account_number') }}"
                                    placeholder="ဥပမာ - 00112233445566"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                                @error('account_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">အကောင့်ပိုင်ရှင်အမည်</label>
                                <input type="text" name="account_holder_name" value="{{ old('account_holder_name') }}"
                                    placeholder="ဥပမာ - U Ba / Daw Mya"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                                @error('account_holder_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Transaction ID & Screenshot -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">လုပ်ငန်းစဉ် အမှတ်</label>
                            <input type="text" name="transaction_id" value="{{ old('transaction_id') }}"
                                placeholder="ဥပမာ - 2024081012345"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                            @error('transaction_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ငွေလွှဲပြေစာ ဓာတ်ပုံ</label>
                            <input type="file" name="payment_screenshot" accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('payment_screenshot')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                @else
                    <!-- Outside Repayment ဖြစ်ပါက တိုက်ရိုက်ပေးချေရန် အသိပေးစာ -->

                @endif

                <!-- Submit Buttons -->
                @if($remainder->status === 'pending')
                    <div class="bg-amber-50 p-4 rounded-lg mb-4 text-amber-800 text-sm">
                        သင်၏ပေးချေမှုကို စောင့်ဆိုင်းဆဲ ဖြစ်ပါသည်
                    </div>
                    <button type="submit"
                        class="w-full bg-amber-600 hover:bg-amber-700 text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition transform active:scale-95">
                        ပေးချေမှု အတည်ပြုမည်
                    </button>
                @else
                    <button type="submit"
                        class="w-full bg-red-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-red-700 transition shadow-lg active:scale-95">
                        ပြန်လည်ပေးချေရန်
                    </button>
                @endif

            @elseif($remainder->status === 'accepted')
                <div class="bg-green-100 p-6 rounded-xl text-center space-y-2 mt-6">
                    <div class="text-4xl">✅</div>
                    <p class="text-sm text-green-700 font-bold">သင်၏ပေးချေမှုအတည်ပြုခြင်း အောင်မြင်ပါသည်။</p>
                </div>

            @elseif($remainder->status === 'repaid')
                <div class="bg-blue-100 p-6 rounded-xl text-center space-y-2 mt-6">
                    <div class="text-4xl">ℹ️</div>
                    <p class="text-blue-800 font-bold">ချေးငွေ ပြန်လည်ပေးဆပ်ထားပြီး အတည်ပြုမှုကို စောင့်ဆိုင်းနေသည်</p>
                </div>
            @endif
        </form>
    </div>

    <!-- ၃။ JavaScript logic -->
    <script>
        function togglePaymentFields(selectedMethod) {
            const detailsSection = document.getElementById('paymentDetailsSection');
            const bankDetailsSection = document.getElementById('bankDetailsSection');

            if (!detailsSection) return;

            if (selectedMethod) {
                detailsSection.classList.remove('hidden');
            }

            if (selectedMethod === 'BankTransfer' && bankDetailsSection) {
                bankDetailsSection.classList.remove('hidden');
            } else if (bankDetailsSection) {
                bankDetailsSection.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const selectedRadio = document.querySelector('input[name="payment_method"]:checked');
            if (selectedRadio) {
                togglePaymentFields(selectedRadio.value);
            }
        });
    </script>
@endsection
