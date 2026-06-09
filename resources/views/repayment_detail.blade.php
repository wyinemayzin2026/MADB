@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow-xl rounded-2xl border border-gray-100">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">ငွေပေးချေမှု အချက်အလက်</h2>
        <p class="text-gray-500 text-sm">သင့်ချေးငွေ ပြန်လည်ဆပ်ရန် အသေးစိတ်</p>
    </div>

    <div class="bg-gray-50 p-5 rounded-xl space-y-4">
        <div class="flex justify-between items-center">
            <span class="text-gray-600">မူရင်းငွေ:</span>
            <span class="font-semibold text-gray-900">{{ number_format($remainder->total_repayment_amount) }} ကျပ်</span>
        </div>

        @if($isOverdue)
            <div class="flex justify-between items-center text-red-600">
                <span class="font-bold">ရက်လွန်ဒဏ်ကြေး:</span>
                <span class="font-bold">+ {{ number_format($penalty) }} ကျပ်</span>
            </div>
        @endif

        <div class="border-t border-gray-200 pt-4 mt-2">
            <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-gray-800">စုစုပေါင်းပေးရန်:</span>
                <span class="text-2xl font-black text-green-700">{{ number_format($netTotal) }} ကျပ်</span>
            </div>
        </div>
    </div>

    <form action="{{ route('loan.repay.process', $loan->id) }}" method="POST" class="mt-8">
        @csrf

        @if($remainder->status === 'pending')
            <div class="bg-amber-50 p-4 rounded-lg mb-4 text-amber-800 text-sm">
                ⚠️ ကျေးဇူးပြု၍ ပမာဏကို စစ်ဆေးပြီး "အတည်ပြုမည်" ကို နှိပ်ပါ။
            </div>
            <button type="submit"
                class="w-full bg-amber-600 hover:bg-amber-700 text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition transform active:scale-95">
                ပေးချေမှု အတည်ပြုမည် (Submit)
            </button>

        @elseif($remainder->status === 'accepted')
            <div class="bg-green-100 p-6 rounded-xl text-center space-y-2">
                <div class="text-4xl">✅</div>
                <p class="text-green-800 font-bold">ပေးချေမှု အောင်မြင်ပါသည်။</p>
                <p class="text-sm text-green-700">ဘဏ်မှ သင်၏ပေးချေမှုကို အတည်ပြုပေးလိုက်ပါပြီ။ သင်၏ချေးငွေအားလုံး ပြန်လည်ဆပ်ပြီးစီးသွားပါပြီ။</p>
            </div>

        @elseif($remainder->status === 'repaid')
            <div class="bg-blue-100 p-6 rounded-xl text-center space-y-2">
                <div class="text-4xl">ℹ️</div>
                <p class="text-blue-800 font-bold">သင်၏ ပေးချေမှုကို အတည်ပြုထားပြီး ဖြစ်ပါသည်။</p>
            </div>

        @elseif($remainder->status === 'rejected')
            <div class="bg-red-50 p-6 rounded-xl text-center space-y-3 border border-red-200">
                <div class="text-4xl">❌</div>
                <p class="text-red-700 font-bold">ပေးချေမှု ပယ်ချခံထားရသည်</p>
                <p class="text-sm text-red-600">ဘဏ်မှ သင်၏ပေးချေမှုကို အတည်မပြုပါ။ အချက်အလက်များ ပြန်လည်စစ်ဆေးပြီး ပြန်လည်လုပ်ဆောင်ပါ။</p>
                <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg font-bold hover:bg-red-700 transition">
                    ပြန်လည်ပေးချေရန် (Retry)
                </button>
            </div>
        @endif
    </form>
</div>
@endsection
