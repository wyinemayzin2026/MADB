@extends('layouts.app')

@section('content')
    <div class="bg-white min-h-screen">

        <div class="relative py-20 bg-green-900 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
                <h1 class="text-4xl md:text-5xl font-black text-white mb-4">ကျွန်ုပ်တို့၏ နောက်ခံသမိုင်းနှင့်
                    ရည်မှန်းချက်များ</h1>
                <div class="w-24 h-2 bg-yellow-500 mx-auto rounded-full"></div>
            </div>
            <i class="fas fa-wheat-awn absolute -left-10 bottom-0 text-[300px] text-white opacity-5"></i>
        </div>

        <section class="max-w-7xl mx-auto px-4 -mt-16 relative z-20 pb-20">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div
                    class="bg-white p-10 rounded-3xl shadow-2xl border-b-8 border-green-600 transform hover:-translate-y-2 transition duration-500">
                    <div
                        class="w-16 h-16 bg-green-100 text-green-700 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">မျှော်မှန်းချက် (Vision)</h2>
                    <p class="text-gray-600 leading-relaxed text-lg italic">
                        "မြန်မာ့လယ်ယာစီးပွားကဏ္ဍ ဖွံ့ဖြိုးတိုးတက်ရေးအတွက် တောင်သူဦးကြီးများအား ငွေကြေးဝန်ဆောင်မှု
                        အထိရောက်ဆုံးပေးနိုင်သည့် ထိပ်တန်းဘဏ်တစ်ခု ဖြစ်လာစေရန်။"
                    </p>
                </div>

                <div
                    class="bg-white p-10 rounded-3xl shadow-2xl border-b-8 border-yellow-500 transform hover:-translate-y-2 transition duration-500">
                    <div
                        class="w-16 h-16 bg-yellow-100 text-yellow-700 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">ရည်မှန်းချက် (Mission)</h2>
                    <ul class="text-gray-600 space-y-4 text-md">
                        <li class="flex gap-3">
                            <i class="fas fa-check-circle text-green-600 mt-1"></i>
                            <span>တောင်သူလယ်သမားများအား လိုအပ်သော စိုက်ပျိုးစရိတ်ချေးငွေများကို အချိန်မီ
                                ထုတ်ချေးပေးရန်။</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-check-circle text-green-600 mt-1"></i>
                            <span>ခေတ်မီလယ်ယာသုံး စက်ကိရိယာများ ဝယ်ယူနိုင်ရန် ရေရှည်ချေးငွေများ ဝန်ဆောင်မှုပေးရန်။</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-check-circle text-green-600 mt-1"></i>
                            <span>ကျေးလက်နေ ပြည်သူများ၏ ငွေစုဆောင်းမှု အလေ့အထကို မြှင့်တင်ပေးရန်။</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="max-w-5xl mx-auto px-4 py-20 border-t border-gray-100">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-green-900 mb-4">ဘဏ်၏ သမိုင်းကြောင်း (History)</h2>
                <p class="text-gray-500">၁၉၅၃ ခုနှစ်မှ ယနေ့အထိ ဖြတ်သန်းလာခဲ့သော ခရီးစဉ်</p>
            </div>

            <div
                class="relative space-y-8 before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-1 before:bg-gradient-to-b before:from-transparent before:via-green-200 before:to-transparent">

                <div
                    class="relative flex items-center tp justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-green-600 text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-landmark text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[45%] p-6 rounded-2xl bg-white shadow-lg border border-gray-100">
                        <time class="font-bold text-green-700 text-xl">၁ ။၁၉၅၃ ခုနှစ်</time>
                        <p class="text-gray-600 mt-2 fs">မြန်မာနိုင်ငံ လွတ်လပ်ရေးရရှိပြီးနောက် တောင်သူလယ်သမားများအား
                            ငွေကြေးအရင်းအနှီး ထောက်ပံ့ပေးရန်အတွက် ၁၉၅၃ ခုနှစ်၊ ဇွန်လ (၁) ရက်နေ့တွင်
                            "နိုင်ငံတော်စိုက်ပျိုးရေးဘဏ်" (State Agricultural Bank - SAB) ကို စတင်ဖွင့်လှစ်ခဲ့ပါသည်။ ထိုစဉ်က
                            ရည်ရွယ်ချက်မှာ တောင်သူများအား အတိုးနှုန်းသက်သာသော ချေးငွေများ ထုတ်ချေးပေးခြင်းဖြင့်
                            အကြွေးဝန်ထုပ်ဝန်ပိုးမှ ကယ်တင်ရန်ဖြစ်ပါသည်။</p>
                    </div>
                </div>

                <div class="relative flex items-center tp  justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-yellow-500 text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-history text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[45%] p-6 rounded-2xl bg-white shadow-lg border border-gray-100">
                        <time class="font-bold text-green-700 text-xl">၂ ။၁၉၉၀ ခုနှစ်</time>
                        <p class="text-gray-600 mt-2 fs">၁၉၆၇ ခုနှစ်တွင် ဘဏ်စနစ်များကို ပြောင်းလဲခဲ့ရာ
                            နိုင်ငံတော်စိုက်ပျိုးရေးဘဏ်ကို ပြည်သူ့ဘဏ် (People's Bank) ၏ စိုက်ပျိုးရေးချေးငွေဌာနခွဲအဖြစ်
                            ပေါင်းစည်းခဲ့ပါသည်။ ၁၉၇၀ ပြည့်နှစ်တွင် မြန်မာ့စီးပွားရေးဘဏ် (MEB) အောက်သို့ ရောက်ရှိသွားပြီး
                            "စိုက်ပျိုးရေးချေးငွေဌာန" အနေဖြင့် လုပ်ငန်းများကို ဆက်လက်ဆောင်ရွက်ခဲ့ပါသည်။</p>
                    </div>
                </div>

                <div class="relative flex  tp items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-green-600 text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-university text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[45%] p-6 rounded-2xl bg-white shadow-lg border border-gray-100">
                        <time class="font-bold text-green-700 text-xl">၃။(၁၉၇၆ ခုနှစ်)</time>
                        <p class="text-gray-600 mt-2 fs">၁၉၇၅ ခုနှစ်တွင် ပြဋ္ဌာန်းခဲ့သော ဘဏ်များဥပဒေအရ ၁၉၇၆ ခုနှစ်၊ ဧပြီလ
                            (၁) ရက်နေ့တွင် "မြန်မာ့စိုက်ပျိုးရေးဘဏ်" (Myanma Agricultural Bank - MAB) အဖြစ်
                            သီးခြားဘဏ်တစ်ခုအနေဖြင့် ပြန်လည်ဖွဲ့စည်း တည်ထောင်ခဲ့ပါသည်။</p>
                    </div>
                </div>

                <div class="relative flex tp items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-yellow-500 text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-history text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[45%] p-6 rounded-2xl bg-white shadow-lg border border-gray-100">
                        <time class="font-bold text-green-700 text-xl">၄။ မြန်မာ့လယ်ယာဖွံ့ဖြိုးရေးဘဏ် ဥပဒေ (၁၉၉၀
                            ခုနှစ်)</time>
                        <p class="text-gray-600 mt-2 fs">နိုင်ငံတော်ငြိမ်ဝပ်ပိပြားမှု တည်ဆောက်ရေးအဖွဲ့ (နဝတ) လက်ထက်တွင်
                            စိုက်ပျိုးရေးကဏ္ဍကို ပိုမိုကျယ်ပြန့်စွာ အထောက်အပံ့ပေးနိုင်ရန် ၁၉၉၀ ပြည့်နှစ်၊ ဇူလိုင်လ (၆)
                            ရက်နေ့တွင် "မြန်မာ့လယ်ယာဖွံ့ဖြိုးရေးဘဏ်ဥပဒေ" (ဥပဒေအမှတ် ၇/၉၀) ကို ပြဋ္ဌာန်းခဲ့ပါသည် ထိုဥပဒေအရ
                            ယနေ့အမည်ဖြစ်သော "မြန်မာ့လယ်ယာဖွံ့ဖြိုးရေးဘဏ်" (Myanma Agricultural Development Bank - MADB) သို့
                            အမည်ပြောင်းလဲခဲ့ပြီး လယ်ယာထွက်ကုန်ပစ္စည်းများ ထုတ်လုပ်မှု တိုးတက်စေရန်နှင့် ကျေးလက်ဒေသ
                            ဖွံ့ဖြိုးရေးအတွက် ငွေကြေးဝန်ဆောင်မှုများကို အရှိန်အဟုန်ဖြင့် ဆောင်ရွက်လာခဲ့ပါသည်။</p>
                    </div>
                </div>

                <div class="relative flex tp items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-yellow-500 text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-history text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[45%] p-6 rounded-2xl bg-white shadow-lg border border-gray-100">
                        <time class="font-bold text-green-700 text-xl">၅။ ဝန်ကြီးဌာန ပြောင်းလဲမှုနှင့် ယနေ့ခေတ်ကာလ</time>
                        <p class="text-gray-600 mt-2 fs">၁၉၉၆ ခုနှစ်: ဘဏ်ကို လယ်ယာစိုက်ပျိုးရေးနှင့် ဆည်မြောင်းဝန်ကြီးဌာန
                            (ယခု စိုက်ပျိုးရေး၊ မွေးမြူရေးနှင့် ဆည်မြောင်းဝန်ကြီးဌာန) အောက်သို့ လွှဲပြောင်းပေးခဲ့သည်။၂၀၁၇
                            ခုနှစ်: နိုင်ငံတော်၏ ဘဏ္ဍာရေးမူဝါဒများ ပိုမိုထိရောက်စေရန် ဘဏ်ကို စီမံကိန်းနှင့်
                            ဘဏ္ဍာရေးဝန်ကြီးဌာန (Ministry of Planning and Finance) အောက်သို့ ပြန်လည်လွှဲပြောင်းခဲ့ပြီး
                            ယနေ့တိုင် အဆိုပါဝန်ကြီးဌာနအောက်တွင် ရပ်တည်လျက်ရှိပါသည်။</p>
                    </div>
                </div>



            </div>
        </section>
    </div>
    <style>
        .tp {
            margin-top: 4px !important;
        }

        .fs {
            font-size: 13px !important;
        }
    </style>
@endsection
