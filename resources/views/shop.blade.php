@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto my-10 p-6 bg-white rounded-xl shadow-lg border border-gray-100">
        <button onclick="toggleLoanList()"
            class="w-full flex justify-between items-center py-4 px-6 bg-green-50 hover:bg-green-100 rounded-lg transition-all border border-green-200 group">
            <span class="text-xl font-bold text-green-800">ချေးငွေအမျိုးအစားများ</span>
            <i id="loan-arrow"
                class="fas fa-chevron-down text-green-600 group-hover:text-green-800 transition-transform duration-300"></i>
        </button>

        <div id="loan-list" class="hidden mt-4 space-y-2">
            @php
                $loans = [
                    [
                        'id' => 1,
                        'title' => 'မိုးစိုက်ပျိုးရေးစရိတ်ချေးငွေ',
                        'image' => asset('assets/img/Lal.png'),
                        'desc' => 'မိုးစိုက်ပျိုးရေးစရိတ်ချေးငွေ မိုးစိုက်ပျိုးရေးစရိတ်ချေးငွေသည် မြန်မာ့လယ်ယာဖွံဖြိုးရေးဘဏ် (MADB) မှ မိုးရာသီတွင် သီးနှံစိုက်ပျိုးသည့် တောင်သူလယ်သမားများအား စိုက်ပျိုးရေးလုပ်ငန်းများ အဆင်ပြေစွာ ဆောင်ရွက်နိုင်ရန် ထုတ်ချေးပေးသော ချေးငွေဖြစ်သည်။ ဤချေးငွေကို မျိုးစေ့၊ ဓာတ်မြေဩဇာ၊ ပိုးသတ်ဆေး၊ လုပ်သားခနှင့် အခြားစိုက်ပျိုးရေးကုန်ကျစရိတ်များအတွက် အသုံးပြုနိုင်သည်။ ထိုကြောင့် တောင်သူများအနေဖြင့် လိုအပ်သော စိုက်ပျိုးရေးပစ္စည်းများကို အချိန်မီဝယ်ယူနိုင်ပြီး မိုးရာသီသီးနှံများကို အောင်မြင်စွာ စိုက်ပျိုးထုတ်လုပ်နိုင်ရန် အထောက်အကူဖြစ်စေပါသည်။ချေးငွေကို မေလမှ စက်တင်ဘာလအထိ ထုတ်ချေးပေးပြီး အတိုးနှုန်း ၅% ကောက်ခံသည်။ ချေးငွေကို ချေးငွေစတင်ထုတ်ချေးသည့်ရက်မှစ၍ တစ်နှစ်အတွင်း ပြန်လည်ပေးဆပ်ရမည်ဖြစ်သည်။ သတ်မှတ်ကာလထက် တစ်နှစ်ကျော်လွန်ပါက တစ်လလျှင် ၆% ဒဏ်တိုး ကောက်ခံမည်ဖြစ်သည်။ချေးငွေလျှောက်ထားရန် တောင်သူများသည် ရုံးသိုလာရောက်၍ ပုံစံ (၇) ယူဆောင်လာရမည် ဖြစ်ပြီး လိုအပ်သော စာရွက်စာတမ်းများကို တင်ပြရမည်။ ထိုအပြင် ချေးငွေထုတ်ယူခြင်းနှင့် ပြန်လည်ပေးဆပ်ခြင်းများ ဆောင်ရွက်နိုင်ရန် ငွေစုစာရင်းအကောင့် ဖွင့်လှစ်ထားရန် လိုအပ်သည်။'
                    ],
                    [
                        'id' => 2,
                        'title' => 'ဆောင်းစိုက်ပျိုးရေးချေးငွေ',
                        'image' => asset('assets/img/Lal.png'),
                        'desc' => 'ဆောင်းရာသီတွင် စိုက်ပျိုးမည့် သီးနှံများအတွက် ထုတ်ပေးသော ချေးငွေဖြစ်သည်။ပဲမျိုးစုံ၊ ဆီထွက်သီးနှံများ၊ ဟင်းသီးဟင်းရွက်များနှင့် အခြားဆောင်းသီးနှံများ စိုက်ပျိုးရန် အသုံးပြုနိုင်သည်။စိုက်ပျိုးရေးထုတ်လုပ်မှု တိုးတက်စေရန်နှင့် တောင်သူများ၏ ငွေကြေးလိုအပ်ချက်ကို ဖြည့်ဆည်းပေးရန် ရည်ရွယ်သည်။သတ်မှတ်ထားသော အတိုးနှုန်းနှင့် ပြန်ဆပ်ကာလအတိုင်း ပြန်လည်ပေးဆပ်ရသည်။'
                    ]
                ];
            @endphp

            @foreach($loans as $loan)
                <div onclick="openLoanModal('{{ $loan['title'] }}', '{{ $loan['desc'] }}', '{{ $loan['image'] }}')"
                    class="p-4 bg-white border border-gray-100 rounded-md hover:bg-green-50 hover:border-green-200 cursor-pointer flex items-center gap-3 transition-all">
                    <div
                        class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold text-sm">
                        {{ $loan['id'] }}
                    </div>
                    <span class="text-gray-700 font-medium">{{ $loan['title'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div id="loan-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div onclick="closeLoanModal()" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        <div class="relative bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden transform transition-all">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2 h-64 md:h-auto bg-gray-200">
                    <img id="modal-loan-img" src="" alt="Loan Image" class="w-full h-full object-cover">
                </div>

                <div class="md:w-1/2 p-8">
                    <h3 id="modal-loan-title" class="text-2xl font-bold text-green-800 mb-4 border-b border-green-100 pb-2">
                    </h3>
                    <p id="modal-loan-desc" class="text-gray-600 leading-relaxed text-sm"></p>

                    <button onclick="closeLoanModal()"
                        class="mt-8 w-full py-3 bg-green-700 hover:bg-green-800 text-white font-bold rounded-xl transition-colors">
                        ပိတ်မည်
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle Accordion List
        function toggleLoanList() {
            const list = document.getElementById('loan-list');
            const arrow = document.getElementById('loan-arrow');

            if (list.classList.contains('hidden')) {
                list.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';
            } else {
                list.classList.add('hidden');
                arrow.style.transform = 'rotate(0deg)';
            }
        }

        // Open Modal with dynamic content including image
        function openLoanModal(title, desc, imgSrc) {
            document.getElementById('modal-loan-title').innerText = title;
            document.getElementById('modal-loan-desc').innerText = desc;

            const modalImg = document.getElementById('modal-loan-img');
            modalImg.src = imgSrc;

            const modal = document.getElementById('loan-modal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }

        // Close Modal
        function closeLoanModal() {
            const modal = document.getElementById('loan-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }
    </script>

    <style>
        /* Smooth Scrolling & Font */
        body {
            font-family: 'Pyidaungsu', sans-serif;
        }
    </style>
@endsection
