@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-xl">
        <h2 class="text-xl font-bold border-b pb-2">ပေးချေရန် အချက်အလက်များ</h2>

        <div class="mt-4 space-y-2">
            <p>မူရင်းငွေ: {{ number_format($remainder->total_repayment_amount) }} ကျပ်</p>

            @if($isOverdue)
                <p class="text-red-600 font-bold">ရက်လွန်ဒဏ်ကြေး: {{ number_format($penalty) }} ကျပ်</p>
            @endif

            <div class="mt-4 pt-4 border-t">
                <p class="text-xl font-bold text-green-700">စုစုပေါင်းပေးရန်: {{ number_format($netTotal) }} ကျပ်</p>
            </div>
        </div>

        <form action="{{ route('loan.repay.process', $loan->id) }}" method="POST" class="mt-6">
            @csrf

            @if($remainder->status === 'pending')
                <button type="submit"
                    class="w-full bg-amber-600 hover:bg-amber-700 text-white py-3 rounded-lg font-bold transition">
                    ငွေပေးချေမှု အတည်ပြုမည် (Submit)
                </button>
            @elseif($remainder->status === 'accepted')
                <button type="button" disabled
                    class="w-full bg-green-500 text-white py-3 rounded-lg font-bold cursor-not-allowed">
                    ✅ ဘဏ်မှ သင်၏ပေးချေမှုကို အတည်ပြုပေးလိုက်ပါပြီ။ ပေးချေမှု အောင်မြင်ပါသည်။
                </button>
            @elseif($remainder->status === 'repaid')
                <button type="button" disabled
                    class="w-full bg-blue-500 text-white py-3 rounded-lg font-bold cursor-not-allowed">
                    ✅ သင်သည် ပေးချေမှုကို အတည်ပြုထားပါသည်။
                </button>
            @else
                 <button type="submit"
                    class="w-full bg-red-500 text-white py-3 rounded-lg font-bold cursor-not-allowed">
                    ❌ ဘဏ်မှ သင်၏ပေးချေမှုကို ပယ်ချထားသည် ။ ပြန်လည်လုပ်ဆောင်ပါ။
                </button>
            @endif
        </form>
    </div>
@endsection
