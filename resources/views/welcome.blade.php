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
            <h2 class="text-4xl md:text-6xl font-black mb-6 leading-tight drop-shadow-xl line-height">
                တောင်သူဦးကြီးများ၏ <br> <span class="text-yellow-400">ဘဝဖွံ့ဖြိုးတိုးတက်ဖို့</span> <br> တို့ဘဏ်က
                ကူညီဆောင်ရွက်ပေးစို့
            </h2>
            <div class="flex gap-4">
                @if(!Auth::guard('borrower')->check())
                    <a href="{{ route('borrower.login') }}"
                        class="inline-block bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg shadow-green-100 transition hover:-translate-y-0.5 text-center">
                        ချေးငွေလျှောက်ထားရန်
                    </a>
                @endif
                <button
                    class="bg-white/20 backdrop-blur-md hover:bg-white/30 px-8 py-4 rounded-xl font-bold text-lg border border-white transition">အသေးစိတ်ဖတ်ရန်</button>
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div
                class="bg-white p-8 rounded-3xl border-t-8 border-green-600 shadow-sm hover:shadow-2xl transition duration-500 group">
                <div
                    class="w-16 h-16 bg-green-100 text-green-700 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-green-600 group-hover:text-white transition">
                    <i class="fas fa-tractor"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-4">စိုက်ပျိုးစရိတ်ချေးငွေ</h4>
                <p class="text-gray-600 leading-relaxed">မိုးစပါး၊ ဆောင်းသီးနှံနှင့် အခြားသီးနှံများအတွက်
                    စိုက်ပျိုးစရိတ်များကို အတိုးနှုန်းသက်သာစွာဖြင့် ထုတ်ချေးပေးပါသည်။</p>
                <a href="#" class="mt-6 inline-block text-green-700 font-bold hover:underline italic">ပိုမိုဖတ်ရှုရန်
                    →</a>
            </div>

            <div
                class="bg-white p-8 rounded-3xl border-t-8 border-yellow-500 shadow-sm hover:shadow-2xl transition duration-500 group">
                <div
                    class="w-16 h-16 bg-yellow-100 text-yellow-700 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-yellow-500 group-hover:text-white transition">
                    <i class="fas fa-tools"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-4">လယ်ယာသုံးစက်ကိရိယာချေးငွေ</h4>
                <p class="text-gray-600 leading-relaxed">ထွန်စက်၊ ရိတ်သိမ်းခြွေလှေ့စက်များနှင့် အခြားစက်ကိရိယာများကို
                    အရစ်ကျစနစ်ဖြင့် ဝယ်ယူနိုင်ရန် ကူညီပေးပါသည်။</p>
                <a href="#" class="mt-6 inline-block text-yellow-600 font-bold hover:underline italic">ပိုမိုဖတ်ရှုရန်
                    →</a>
            </div>

            <div
                class="bg-white p-8 rounded-3xl border-t-8 border-green-600 shadow-sm hover:shadow-2xl transition duration-500 group">
                <div
                    class="w-16 h-16 bg-green-100 text-green-700 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-green-600 group-hover:text-white transition">
                    <i class="fas fa-piggy-bank"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-4">စုဆောင်းငွေဝန်ဆောင်မှု</h4>
                <p class="text-gray-600 leading-relaxed">တောင်သူဦးကြီးများ၏ ပိုလျှံငွေများကို လုံခြုံစိတ်ချစွာ
                    စုဆောင်းနိုင်ပြီး အတိုးနှုန်းကောင်းကောင်း ရရှိနိုင်ပါသည်။</p>
                <a href="#" class="mt-6 inline-block text-green-700 font-bold hover:underline italic">ပိုမိုဖတ်ရှုရန်
                    →</a>
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
