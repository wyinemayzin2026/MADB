<!--End Brands-->
@extends('layouts.app')

@section('content')

    <header class="relative h-[550px] overflow-hidden">
        <div class="absolute inset-0 bg-black/40 z-10"></div>
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1920&q=80"
            class="absolute inset-0 w-full h-full object-cover transform scale-105" alt="Paddy Field">

        <div class="relative z-20 h-full max-w-7xl mx-auto px-4 flex flex-col justify-center items-start text-white">
            <span
                class="bg-yellow-500 text-black px-4 py-1 rounded-sm font-bold text-sm mb-4 uppercase tracking-widest">မြန်မာ့စိုက်ပျိုးရေး၏
                ယုံကြည်စိတ်ချရသော မိတ်ဖက်</span>
            <h2 class="text-3xl font-black mb-6 leading-tight drop-shadow-xl line-height">
                တောင်သူဦးကြီးများ၏ ဘဝဖွံ့ဖြိုးတိုးတက်ဖို့ တို့ဘဏ်က ကူညီဆောင်ရွက်ပေးစို့
            </h2>
            <div class="flex gap-4">
                @if(!Auth::guard('borrower')->check())
                    <a href="{{ route('borrower.login') }}"
                        class="inline-block bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg shadow-green-100 transition hover:-translate-y-0.5 text-center">
                        ချေးငွေလျှောက်ထားရန်
                    </a>
                @else
                    <a href="{{ route('borrower.loan') }}"
                        class="inline-block bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg shadow-green-100 transition hover:-translate-y-0.5 text-center">
                        ချေးငွေလျှောက်ထားရန်
                    </a>
                @endif

            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 z-30">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L1440 120L1440 0C1160 80 280 80 0 0L0 120Z" fill="#f9fafb" />
            </svg>
        </div>
    </header>

    <section class="max-w-7xl mx-auto py-20 px-4">
        <div class="text-center mb-16">
            <h3 class="text-3xl font-bold text-green-900 mb-2">ဘဏ်၏ ဝန်ဆောင်မှုများ</h3>
            <div class="w-24 h-1.5 bg-yellow-500 mx-auto rounded-full"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-1 gap-10">

        <!-- Card 1 -->
        <div class="bg-white p-8 rounded-3xl border-t-8 border-green-600 shadow-sm hover:shadow-2xl transition duration-500 group flex flex-col justify-between">
            <div>
                <div class="w-16 h-16 bg-green-100 text-green-700 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-green-600 group-hover:text-white transition">
                    <i class="fas fa-tractor"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-4">စိုက်ပျိုးစရိတ်ချေးငွေ</h4>
                <p class="text-gray-600 leading-relaxed text-justify">
                    စိုက်ပျိုးစရိတ်ချေးငွေဆိုသည်မှာ တောင်သူလယ်သမားများ၏ စိုက်ပျိုးရေးလုပ်ငန်းများအတွက် လိုအပ်သော ငွေကြေးအရင်းအနှီးကို ကူညီပံ့ပိုးပေးသည့် ချေးငွေအမျိုးအစားတစ်ခုဖြစ်သည်။ တောင်သူများသည် မျိုးစေ့၊ မြေဩဇာ၊ ပိုးသတ်ဆေး၊ စိုက်ပျိုးရေးသုံးပစ္စည်းများ၊ လယ်ယာလုပ်သားခနှင့် စက်ယန္တရားအသုံးပြုခများကဲ့သိုသော စိုက်ပျိုးရေးဆိုင်ရာ ကုန်ကျစရိတ်များအတွက် ဤချေးငွေကို အသုံးပြုနိုင်သည်။ စိုက်ပျိုးစရိတ်ချေးငွေသည် တောင်သူများ၏ လုပ်ငန်းလည်ပတ်ငွေလိုအပ်ချက်ကို ဖြည့်ဆည်းပေးနိုင်ပြီး စိုက်ပျိုးထုတ်လုပ်မှုကို တိုးတက်စေရန် အထောက်အကူပြုသည်။ ထိုအပြင် သတ်မှတ်ထားသော စည်းမျဉ်းစည်းကမ်းများနှင့်အညီ ချေးငွေလျှောက်ထားခြင်း၊ စိစစ်အတည်ပြုခြင်းနှင့် သတ်မှတ်ကာလအတွင်း ပြန်လည်ပေးဆပ်ခြင်းတိုကို ဆောင်ရွက်ရသည်။ ထိုသို စနစ်တကျ စီမံခန့်ခွဲပေးခြင်းဖြင့် တောင်သူများအတွက် လိုအပ်သော စိုက်ပျိုးရေးအရင်းအနှီးကို အချိန်မီရရှိစေပြီး စိုက်ပျိုးရေးကဏ္ဍ ဖွံဖြိုးတိုးတက်ရေးကို အထောက်အကူပြုနိုင်သည်။
                </p>
            </div>
        </div>

        <!-- Card 2 -->


        <!-- Card 3 -->


    </div>
</div>
    </section>

    <section class="bg-green-900 py-16 text-white overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-8 text-center relative z-10">
            <div>
                <p class="text-4xl font-black text-yellow-400 mb-2">၂၀၀+</p>
                <p class="text-sm font-medium opacity-80 uppercase tracking-widest">ဘဏ်ခွဲပေါင်း</p>
            </div>
            <div>
                <p class="text-4xl font-black text-yellow-400 mb-2">၃ သန်း+</p>
                <p class="text-sm font-medium opacity-80 uppercase tracking-widest">တောင်သူဦးရေ</p>
            </div>
            <div>
                <p class="text-4xl font-black text-yellow-400 mb-2">၆၅ နှစ်+</p>
                <p class="text-sm font-medium opacity-80 uppercase tracking-widest">သက်တမ်း</p>
            </div>
            <div>
                <p class="text-4xl font-black text-yellow-400 mb-2">၂၄/၇</p>
                <p class="text-sm font-medium opacity-80 uppercase tracking-widest">ဝန်ဆောင်မှု</p>
            </div>
        </div>
        <i class="fas fa-wheat-awn absolute right-[-50px] bottom-[-50px] text-[300px] opacity-5 pointer-events-none"></i>
    </section>
    <style>
        .line-height {
            line-height: 1.2;
        }

@endsection
