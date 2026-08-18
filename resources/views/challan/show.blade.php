<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ကောက်ခံရငွေအသေးစိတ်စာရင်း - #{{ $challen->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white; padding: 0; margin: 0; font-family: 'Pyidaungsu', 'Myanmar Text', sans-serif; }
            .print-container { width: 100% !important; max-width: 100% !important; border: none !important; box-shadow: none !important; padding: 0 !important; }
        }
        table, th, td {
            border: 1px solid black !important;
        }
    </style>
</head>
<body class="bg-gray-100 p-6 text-black text-sm">
@php
    // လက်ရှိနှစ် (သို့မဟုတ်) loan_start_date ၏ နောက်ဆုံး ဂဏန်း ၂ လုံးကို ယူမည်
    $yearShort = date('y'); // 2025 ဆိုလျှင် 25 ၊ 2026 ဆိုလျှင် 26 ထွက်မည်
@endphp
    <!-- Action Bar (Print ရိုက်ချိန်မပါပါ) -->
    <div class="max-w-6xl mx-auto mb-4 flex justify-between items-center no-print">
        <button onclick="window.close()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-xs font-bold">
            ⬅ ပိတ်မည်
        </button>
        <button onclick="window.print()" class="px-5 py-2 bg-blue-600 text-white font-bold rounded-lg shadow hover:bg-blue-700 text-xs">
            🖨️ စာရွက် ပရင့်ထုတ်မည် (Print)
        </button>
    </div>

    <!-- Main Form Container -->
    <div class="print-container max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-md border border-gray-300">

        <!-- Top Header Info -->
        <div class="flex justify-between items-start mb-2">
            <div class="text-xs space-y-1">
                <p class="font-bold">ဖွံ့ဖြိုးဘဏ်</p>
                <p>န၀-၇</p>
            </div>
            <div class="text-center">
                <h1 class="text-xl font-bold border-b border-black pb-0.5 inline-block">ကောက်ခံရငွေအသေးစိတ်စာရင်း</h1>
            </div>
            <div class="text-xs space-y-1 text-right">
                <p>ချေးငွေအမျိုးအစား <span class="border-b border-dotted border-black px-2 font-bold">{{ $yearShort . $item->season_type === 'rainy' ? 'မိုး ' : $yearShort .  'ဆောင်း ' }}</span></p>
                <p>ဘဏ္ဍာရေးနှစ် <span class="border-b border-dotted border-black px-2">{{ date('Y') }}</span></p>
            </div>
        </div>

        <!-- Township / Ward Row -->
        <div class="flex justify-start gap-12 text-xs mb-3 font-semibold">
            <p>မြို့နယ် - <span class="font-normal border-b border-dotted border-black px-4">{{ $item->workplace_address ?? 'ကလော' }}</span></p>
        </div>

        <!-- Form Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-center text-xs">
                <thead>
                    <tr class="bg-gray-50">
                        <th rowspan="2" class="p-1 w-8">စဉ်</th>
                        <th rowspan="2" class="p-1">ပေးဆပ်သူ အမည်</th>
                        <th rowspan="2" class="p-1">အာမခံသူ အမည်</th>
                        <th rowspan="2" class="p-1">အစု အဖွဲ့ အမှတ်</th>
                        <th rowspan="2" class="p-1">ထုတ်ချေး သည့် နေ့စွဲ</th>
                        <th rowspan="2" class="p-1">ကောက်ခံ ရရှိသည့် နေ့စွဲ</th>
                        <th rowspan="2" class="p-1">ဒဏ်တိုး တွက်သည့် ကာလ</th>
                        <th colspan="5" class="p-1">ပြန်လည်ပေးဆပ်သည့်</th>
                        <th rowspan="2" class="p-1">စုစုပေါင်းငွေ</th>
                        <th rowspan="2" class="p-1">ငွေရ ပြေစာ အမှတ်</th>
                    </tr>
                    <tr class="bg-gray-50">
                        <th class="p-1">အရင်း (ကျပ်)</th>
                        <th class="p-1">အတိုး (ကျပ်)</th>
                        <th class="p-1">ပြား</th>
                        <th class="p-1">ဒဏ်အတိုး (ကျပ်)</th>
                        <th class="p-1">ပြား</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-2">၁။</td>
                        <!-- ပေးဆပ်သူအမည် -->
                        <td class="p-2 font-semibold text-left">{{ $item->borrower->full_name ?? 'ဦးဝင်းဦး' }}</td>
                        <!-- အာမခံသူအမည် -->
                        <td class="p-2 text-left">{{ $item->guarantor_name }}</td>
                        <!-- အစုအဖွဲ့အမှတ် -->
                        <td class="p-2">{{ $item->saving_account_number ?? '-' }}</td>
                        <!-- ထုတ်ချေးသည့်နေ့စွဲ -->
                        <td class="p-2">{{ \Carbon\Carbon::parse($item->crerated_at)->format('d/m/Y') }}</td>
                        <!-- ကောက်ခံရရှိသည့်နေ့စွဲ -->
                        <td class="p-2">{{ \Carbon\Carbon::parse($challen->repayment_date ?? $challen->updated_at)->format('d/m/Y') }}</td>
                        <!-- အတိုးတွက်သည့်ကာလ -->
                        <td class="p-2">{{ $challen->months_overdue ?? 1 }} လ</td>

                        <!-- ပြန်လည်ပေးဆပ်သည့် အရင်း -->
                        <td class="p-2 text-right">
                            {{ str_replace(['0','1','2','3','4','5','6','7','8','9'], ['၀','၁','၂','၃','၄','၅','၆','၇','၈','၉'], number_format($item->total_amount)) }}
                        </td>
                        <!-- အတိုး (ကျပ်) -->
                        <td class="p-2 text-right">
                            {{ str_replace(['0','1','2','3','4','5','6','7','8','9'], ['၀','၁','၂','၃','၄','၅','၆','၇','၈','၉'], number_format($item->total_amount * ($item->rate / 100))) }}
                        </td>
                        <!-- အတိုး (ပြား) -->
                        <td class="p-2">-</td>

                        <!-- ဒဏ်အတိုး (ကျပ်) -->
                        <td class="p-2 text-right">
                            @php
                                $penalty = $challen->net_total_repayment_amount - $challen->total_repayment_amount;
                            @endphp
                            {{ $penalty > 0 ? str_replace(['0','1','2','3','4','5','6','7','8','9'], ['၀','၁','၂','၃','၄','၅','၆','၇','၈','၉'], number_format($penalty)) : '-' }}
                        </td>
                        <!-- ဒဏ်အတိုး (ပြား) -->
                        <td class="p-2">-</td>

                        <!-- စုစုပေါင်းငွေ -->
                        <td class="p-2 text-right font-bold">
                            {{ str_replace(['0','1','2','3','4','5','6','7','8','9'], ['၀','၁','၂','၃','၄','၅','၆','၇','၈','၉'], number_format($challen->net_total_repayment_amount)) }}
                        </td>
                        <!-- ငွေရပြေစာအမှတ် -->
                        <td class="p-2 font-mono">#{{ str_pad($challen->id, 5, '0', STR_PAD_LEFT) }}</td>
                    </tr>

                    <!-- Blank rows to mimic paper structure -->

                </tbody>
            </table>
        </div>

        {{-- <!-- Footer Signature Section -->
        <div class="flex justify-between items-end mt-16 text-xs px-6">
            <div class="text-center">
                <p class="mb-12">ပြုစုသူ</p>
                <p>လက်မှတ် .................................</p>
            </div>
            <div class="text-center">
                <p class="mb-12">စစ်ဆေးသူ</p>
                <p>လက်မှတ် .................................</p>
            </div>
            <div class="text-center">
                <p class="mb-12">ငွေကိုင်</p>
                <p>လက်မှတ် .................................</p>
            </div>
            <div class="text-center">
                <p class="mb-12">မန်နေဂျာ</p>
                <p>လက်မှတ် ..................ငွေရ ပြေစာ အမှတ်...............</p>
            </div>
        </div> --}}

    </div>

</body>
</html>
