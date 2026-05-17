<!DOCTYPE html>
<html lang="my">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>မြန်မာလယ်ယာဖွံ့ဖြိုးရေးဘဏ် - MADB</title>
</head>

<body class="bg-gray-50 font-sans">

    <nav class="bg-white shadow-lg sticky top-0 z-50 border-b-4 border-green-600">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <div
                        class="relative w-14 h-14 rounded-full flex items-center justify-center shadow-lg border-2 border-yellow-400 overflow-hidden transition-transform group-hover:scale-110">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="MADB Logo"
                            class="absolute inset-0 w-full h-full object-contain">

                        <div class="absolute inset-0 bg-gradient-to-tr from-green-800 to-transparent opacity-50 z-10">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-green-800 font-bold text-lg leading-tight">MADB</h1>
                        <p class="text-xs text-yellow-600 font-semibold tracking-tighter">မြန်မာလယ်ယာဖွံ့ဖြိုးရေးဘဏ်</p>
                    </div>
                </div>

                <div class="hidden md:flex space-x-8 font-medium text-gray-700">
                    <a href="{{ url('/') }}"
                        class="hover:text-green-700 transition border-b-2 border-transparent hover:border-green-700 pb-1">ပင်မစာမျက်နှာ</a>
                    <a href="{{ url('/about') }}"
                        class="hover:text-green-700 transition border-b-2 border-transparent hover:border-green-700 pb-1">ဘဏ်အကြောင်း</a>
                    <a href="{{ url('/shop') }}"
                        class="hover:text-green-700 transition border-b-2 border-transparent hover:border-green-700 pb-1">ချေးငွေဝန်ဆောင်မှုများ</a>
                    <a href="{{ url('/contact') }}"
                        class="hover:text-green-700 transition border-b-2 border-transparent hover:border-green-700 pb-1">
                        ဆက်သွယ်ရန်</a>
                </div>

                <div class="flex items-center gap-4">
                    @if(Auth::guard('borrower')->check())
                        <div class="relative inline-block text-left group">
                            <button type="button"
                                class="flex items-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 px-5 py-2.5 rounded-full text-sm font-bold border border-emerald-200 transition shadow-sm outline-none">
                                <i class="fas fa-user-circle text-emerald-600 text-base"></i>
                                <span>{{ Auth::guard('borrower')->user()->full_name }}</span>
                                <i
                                    class="fas fa-chevron-down text-[10px] text-emerald-600 transition-transform group-hover:rotate-180"></i>
                            </button>

                            <div
                                class="absolute right-0 w-48 mt-1 origin-top-right bg-white rounded-2xl shadow-xl border border-slate-100 p-1.5 hidden group-hover:block animate-fade-in z-50">

                                <hr class="border-slate-100 my-1">

                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('borrower-logout-form').submit();"
                                    class="flex items-center gap-2.5 px-4 py-3 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition">
                                    <i class="fas fa-sign-out-alt"></i> စနစ်မှထွက်ရန်
                                </a>

                                <form id="borrower-logout-form" action="{{ route('borrower.logout') }}" method="POST"
                                    class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('staff.login') }}"
                            class="bg-green-700 text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-blue-800 transition shadow-lg inline-block">
                            အကောင့်ဝင်ရန်
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    @yield('content')
    <footer class="bg-green-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white rounded-full p-1 shadow-inner">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="MADB Logo"
                            class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight">MADB</h2>
                        <p class="text-[10px] text-yellow-400 font-semibold leading-none uppercase">Agricultural
                            Development Bank</p>
                    </div>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed pt-2">
                    ၁၉၅၃ ခုနှစ်မှစတင်၍ မြန်မာ့လယ်ယာစီးပွားကဏ္ဍ ဖွံ့ဖြိုးတိုးတက်ရေးအတွက် တောင်သူဦးကြီးများ၏
                    ယုံကြည်စိတ်ချရသော မိတ်ဖက်ဘဏ်အဖြစ် ရပ်တည်လျက်ရှိပါသည်။
                </p>
                <div class="flex gap-4 pt-2">
                    <a href="#"
                        class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-yellow-500 transition-colors"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="#"
                        class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-yellow-500 transition-colors"><i
                            class="fas fa-globe"></i></a>
                    <a href="#"
                        class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-yellow-500 transition-colors"><i
                            class="fab fa-viber"></i></a>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold border-b-2 border-yellow-500 w-fit pb-1 mb-6">အမြန်ကြည့်ရန်</h3>
                <ul class="space-y-3 text-gray-300 text-sm">
                    <li><a href="{{ url('/') }}" class="hover:text-yellow-400 flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[10px]"></i> ပင်မစာမျက်နှာ</a></li>
                    <li><a href="{{ url('/about') }}" class="hover:text-yellow-400 flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[10px]"></i> ဘဏ်အကြောင်း</a></li>
                    <li><a href="{{ url('/shop') }}" class="hover:text-yellow-400 flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[10px]"></i> ချေးငွေဝန်ဆောင်မှုများ</a></li>
                    <li><a href="{{ url('/contact') }}" class="hover:text-yellow-400 flex items-center gap-2"><i
                                class="fas fa-chevron-right text-[10px]"></i> ဆက်သွယ်ရန်</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold border-b-2 border-yellow-500 w-fit pb-1 mb-6">ဝန်ဆောင်မှုများ</h3>
                <ul class="space-y-3 text-gray-300 text-sm">
                    <li><a href="#" class="hover:text-yellow-400">စိုက်ပျိုးစရိတ်ချေးငွေ</a></li>
                    <li><a href="#" class="hover:text-yellow-400">လယ်ယာသုံးစက်ကိရိယာချေးငွေ</a></li>
                    <li><a href="#" class="hover:text-yellow-400">JICA Two Step Loan</a></li>
                    <li><a href="#" class="hover:text-yellow-400">စုဆောင်းငွေ ဝန်ဆောင်မှု</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold border-b-2 border-yellow-500 w-fit pb-1 mb-6">ရုံးချုပ်လိပ်စာ</h3>
                <ul class="space-y-4 text-gray-300 text-sm">
                    <li class="flex gap-3">
                        <i class="fas fa-map-marker-alt text-yellow-500 mt-1"></i>
                        <span>အမှတ် (၂၆/၄၂)၊ ပန်းဆိုးတန်းလမ်း၊ ကျောက်တံတားမြို့နယ်၊ ရန်ကုန်မြို့။</span>
                    </li>
                    <li class="flex gap-3">
                        <i class="fas fa-phone-alt text-yellow-500 mt-1"></i>
                        <span>၀၁-၃၉၁၃၄၂၊ ၀၁-၃၉၁၃၄၃</span>
                    </li>
                    <li class="flex gap-3">
                        <i class="fas fa-envelope text-yellow-500 mt-1"></i>
                        <span>madb@mptmail.net.mm</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 mt-16 pt-8 border-t border-white/10 text-center">
            <p class="text-xs text-gray-400">
                မူပိုင်ခွင့် © ၂၀၂၆ မြန်မာလယ်ယာဖွံ့ဖြိုးရေးဘဏ်။ All Rights Reserved.
            </p>
        </div>
    </footer>

    <script src="{{ asset('assets/js/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/templatemo.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <style>
        .footer-link {
            padding: 20px 100px;
        }
    </style>

</body>

</html>
