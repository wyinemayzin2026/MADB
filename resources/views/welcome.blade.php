@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <header class="relative h-[580px] overflow-hidden">
        <!-- Bright Creative Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-emerald-950/40 to-transparent z-10"></div>

        <!-- Bright & Creative Agriculture Background Image -->
        <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=1920&q=80"
            class="absolute inset-0 w-full h-full object-cover transform scale-105 transition-transform duration-1000" alt="Bright Green Rice Field">

        <div class="relative z-20 h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col justify-center items-start text-white">
            <!-- Badge -->
            <span class="inline-flex items-center gap-2 bg-amber-400 text-slate-900 px-4 py-1.5 rounded-full font-bold text-sm mb-6 uppercase tracking-wider shadow-lg shadow-amber-500/20">
                <i class="fas fa-seedling"></i> တောင်သူများအတွက်
            </span>

            <!-- Main Title from Image -->
            <h1 class="text-3xl sm:text-5xl font-black mb-6 leading-tight drop-shadow-xl max-w-3xl text-emerald-50">
                လွယ်ကူမြန်ဆန်သော <br class="hidden sm:inline"><br class="hidden sm:inline">
                <span class="text-amber-400">ဒစ်ဂျစ်တယ်ချေးငွေ</span> ဝန်ဆောင်မှု
            </h1>

            <!-- Subtitle Description from Image -->
            <p class="text-lg sm:text-xl text-slate-100 mb-8 max-w-2xl leading-relaxed font-normal drop-shadow">
                အွန်လိုင်းမှတစ်ဆင့် ချေးငွေလျှောက်ထားခြင်း၊ အတည်ပြုခြင်းနှင့် <br><br>ပြန်လည်ပေးဆပ်ခြင်းတို့ကို လွယ်ကူမြန်ဆန်စွာ ဆောင်ရွက်နိုင်ပါသည်။
            </p>

            <!-- CTA Button -->
            <div class="flex flex-wrap gap-4">
                @if(!Auth::guard('borrower')->check())
                    <a href="{{ route('borrower.login') }}"
                        class="inline-flex items-center gap-3 bg-emerald-600 hover:bg-emerald-500 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-xl shadow-emerald-900/30 transition-all duration-300 hover:-translate-y-1 active:scale-95">
                        <i class="fas fa-paper-plane"></i> ချေးငွေလျှောက်ထားရန်
                    </a>
                @else
                    <a href="{{ route('borrower.loan') }}"
                        class="inline-flex items-center gap-3 bg-emerald-600 hover:bg-emerald-500 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-xl shadow-emerald-900/30 transition-all duration-300 hover:-translate-y-1 active:scale-95">
                        <i class="fas fa-paper-plane"></i> ချေးငွေလျှောက်ထားရန်
                    </a>
                @endif
            </div>
        </div>

        <!-- Curve Separator -->
        <div class="absolute bottom-0 left-0 right-0 z-30 pointer-events-none">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L1440 120L1440 0C1160 80 280 80 0 0L0 120Z" fill="#f8fafc" />
            </svg>
        </div>
    </header>

    <!-- Services Section -->
    <section class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h3 class="text-3xl font-bold text-emerald-950 mb-3">ဘဏ်၏ ဝန်ဆောင်မှုများ</h3>
            <div class="w-24 h-1.5 bg-amber-400 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 gap-10">
            <!-- Card 1 -->
            <div class="bg-white p-8 sm:p-10 rounded-3xl border-t-8 border-emerald-600 shadow-sm hover:shadow-2xl transition duration-500 group flex flex-col justify-between">
                <div>
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-700 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                        <i class="fas fa-tractor"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-slate-800 mb-4">စိုက်ပျိုးစရိတ်ချေးငွေ</h4>
                    <p class="text-slate-600 leading-relaxed text-justify">
                        စိုက်ပျိုးစရိတ်ချေးငွေဆိုသည်မှာ တောင်သူလယ်သမားများ၏ စိုက်ပျိုးရေးလုပ်ငန်းများအတွက် လိုအပ်သော ငွေကြေးအရင်းအနှီးကို ကူညီပံ့ပိုးပေးသည့် ချေးငွေအမျိုးအစားတစ်ခုဖြစ်သည်။ တောင်သူများသည် မျိုးစေ့၊ မြေဩဇာ၊ ပိုးသတ်ဆေး၊ စိုက်ပျိုးရေးသုံးပစ္စည်းများ၊ လယ်ယာလုပ်သားခနှင့် စက်ယန္တရားအသုံးပြုခများကဲ့သို့သော စိုက်ပျိုးရေးဆိုင်ရာ ကုန်ကျစရိတ်များအတွက် ဤချေးငွေကို အသုံးပြုနိုင်သည်။ စိုက်ပျိုးစရိတ်ချေးငွေသည် တောင်သူများ၏ လုပ်ငန်းလည်ပတ်ငွေလိုအပ်ချက်ကို ဖြည့်ဆည်းပေးနိုင်ပြီး စိုက်ပျိုးထုတ်လုပ်မှုကို တိုးတက်စေရန် အထောက်အကူပြုသည်။ ထို့အပြင် သတ်မှတ်ထားသော စည်းမျဉ်းစည်းကမ်းများနှင့်အညီ ချေးငွေလျှောက်ထားခြင်း၊ စိစစ်အတည်ပြုခြင်းနှင့် သတ်မှတ်ကာလအတွင်း ပြန်လည်ပေးဆပ်ခြင်းတို့ကို ဆောင်ရွက်ရသည်။ ထိုသို့ စနစ်တကျ စီမံခန့်ခွဲပေးခြင်းဖြင့် တောင်သူများအတွက် လိုအပ်သော စိုက်ပျိုးရေးအရင်းအနှီးကို အချိန်မီရရှိစေပြီး စိုက်ပျိုးရေးကဏ္ဍ ဖွံ့ဖြိုးတိုးတက်ရေးကို အထောက်အကူပြုနိုင်သည်။
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    {{-- <section class="bg-emerald-900 py-16 text-white overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-8 text-center relative z-10">
            <div>
                <p class="text-4xl sm:text-5xl font-black text-amber-400 mb-2">၂၀၀+</p>
                <p class="text-sm font-medium opacity-90 uppercase tracking-widest">ဘဏ်ခွဲပေါင်း</p>
            </div>
            <div>
                <p class="text-4xl sm:text-5xl font-black text-amber-400 mb-2">၃ သန်း+</p>
                <p class="text-sm font-medium opacity-90 uppercase tracking-widest">တောင်သူဦးရေ</p>
            </div>
            <div>
                <p class="text-4xl sm:text-5xl font-black text-amber-400 mb-2">၆၅ နှစ်+</p>
                <p class="text-sm font-medium opacity-90 uppercase tracking-widest">သက်တမ်း</p>
            </div>
            <div>
                <p class="text-4xl sm:text-5xl font-black text-amber-400 mb-2">၂၄/၇</p>
                <p class="text-sm font-medium opacity-90 uppercase tracking-widest">ဝန်ဆောင်မှု</p>
            </div>
        </div>
        <i class="fas fa-wheat-awn absolute right-[-50px] bottom-[-50px] text-[300px] opacity-5 pointer-events-none"></i>
    </section> --}}

@endsection
