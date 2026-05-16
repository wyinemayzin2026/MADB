@extends('layouts.app')

@section('content')
    <!-- MADB Theme Animation Styles -->
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }

            50% {
                opacity: 1;
                transform: scale(1.05);
            }

            70% {
                transform: scale(0.9);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-fade-up {
            animation: fadeInUp 1s ease-out forwards;
        }

        .animate-bounce-in {
            animation: bounceIn 1s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }
    </style>

    <div
        class="min-h-screen bg-gradient-to-br from-emerald-50 via-slate-50 to-amber-50/50 flex items-center justify-center p-4">
        <div class="w-full max-w-[450px]">

            <!-- MADB Logo Animation: Bounce In -->
            <div class="text-center mb-8 animate-bounce-in">
                <h2 class="text-2xl font-black text-emerald-900 tracking-tight font-sans">MADB Staff Portal</h2>
                <p class="text-xs text-emerald-600 font-medium mt-1">မြန်မာလယ်ယာဖွံ့ဖြိုးရေးဘဏ်</p>
            </div>

            <!-- Login Card Animation: Fade Up -->
            <div class="animated-border-card bg-white rounded-[32px] shadow-2xl shadow-emerald-900/5 border border-emerald-100/50 p-8 md:p-10 relative overflow-hidden animate-fade-up"
                style="animation-delay: 0.2s;">

                <!-- Top Decorative Bar -->
                <div
                    class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-emerald-600 via-amber-400 to-emerald-700">
                </div>

                <form action="{{ route('staff.login.submit') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Error Alert: Fade In -->
                    @if ($errors->any())
                        <div
                            class="bg-red-50 text-red-600 text-xs font-bold p-4 rounded-2xl border border-red-100 animate-pulse">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Employee ID Input -->
                    <div class="space-y-2">
                        <label class="text-xs font-black text-emerald-800/60 uppercase tracking-widest ml-1">ဝန်ထမ်းအမှတ်
                            (EID)</label>
                        <div class="relative group">
                            <input type="number" name="eid" value="{{ old('eid') }}" min="1" placeholder="ဥပမာ - ၁၀၀၁"
                                required
                                class="w-full bg-emerald-50/30 border border-slate-200 rounded-2xl px-12 py-4 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-emerald-100 focus:border-emerald-600 outline-none transition-all duration-300 group-hover:border-emerald-300 text-slate-800">
                            <i
                                class="fas fa-seedling absolute left-5 top-1/2 -translate-y-1/2 text-emerald-300 group-focus-within:text-emerald-600 transition-colors"></i>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label
                                class="text-xs font-black text-emerald-800/60 uppercase tracking-widest">လျှိဝှက်နံပါတ်</label>
                            <a href="#"
                                class="text-xs font-bold text-emerald-700 hover:text-amber-600 hover:underline transition-all">မေ့သွားပါသလား?</a>
                        </div>
                        <div class="relative group">
                            <input type="password" name="password" id="password" placeholder="••••••••" required
                                class="w-full bg-emerald-50/30 border border-slate-200 rounded-2xl px-12 py-4 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-emerald-100 focus:border-emerald-600 outline-none transition-all duration-300 group-hover:border-emerald-300 text-slate-800">
                            <i
                                class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-emerald-300 group-focus-within:text-emerald-600 transition-colors"></i>
                            <button type="button" onclick="togglePass()"
                                class="absolute right-5 top-1/2 -translate-y-1/2 text-emerald-300 hover:text-emerald-600 transition-colors">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button with MADB Branding -->
                    <button type="submit"
                        class="w-full bg-emerald-700 text-white rounded-2xl py-4 font-black text-sm shadow-xl shadow-emerald-700/20 hover:bg-emerald-800 hover:-translate-y-1 active:scale-[0.98] transition-all duration-300 flex items-center justify-center group">
                        <span class="tracking-wide">လုံခြုံစွာဖြင့် လော့ဂ်အင်ဝင်ရန်</span>
                        <i
                            class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform text-amber-400"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        function togglePass() {
            const passInput = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>

    <style>
        /* Card Container */
        .animated-border-card {
            position: relative;
            background: white;
            z-index: 0;
        }

        /* MADB Conic Gradient Border (Emerald -> Gold -> Emerald) */
        .animated-border-card::before {
            content: '';
            position: absolute;
            z-index: -2;
            left: -2px;
            top: -2px;
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            background: conic-gradient(from 0deg, #047857, #fbbf24, #047857);
            animation: rotateBorder 4s linear infinite;
        }

        /* Inner Mask */
        .animated-border-card::after {
            content: '';
            position: absolute;
            z-index: -1;
            left: 2px;
            top: 2px;
            width: calc(100% - 4px);
            height: calc(100% - 4px);
            background: white;
            border-radius: 30px;
        }

        @keyframes rotateBorder {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
    </style>
@endsection
