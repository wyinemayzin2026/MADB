@extends('layouts.staff_app')

@section('content')

    <!-- Main Dynamic Content Panel -->
    <main class="flex-1 p-6 md:p-8 animate-fade-in">

        <!-- Welcome & Time Header -->
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                    <i class="fas fa-chart-line text-emerald-600"></i> စနစ်အတွင်းရှိ နောက်ဆုံးရ ဘဏ်လုပ်ငန်းအချက်အလက်များ
                </h2>
                <p class="text-xs font-semibold text-slate-400 mt-1">မြန်မာလယ်ယာဖွံ့ဖြိုးရေးဘဏ် (MADB) ၏
                    နေ့စဉ်လုပ်ငန်းဆောင်ရွက်မှု ဇယား</p>
            </div>
            <div
                class="bg-white px-4 py-2 rounded-xl border border-slate-100 shadow-sm text-xs font-bold text-slate-500 flex items-center gap-2">
                <i class="far fa-calendar-alt text-emerald-600"></i>
                <span>ယနေ့ရက်စွဲ - {{ now()->format('d/m/Y') }}</span>
            </div>
        </header>

        <!-- Premium Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

            <!-- Card 1: Total Farmers -->
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all relative overflow-hidden group">
                <div
                    class="absolute right-0 bottom-0 translate-x-4 translate-y-4 opacity-5 group-hover:scale-110 transition-all text-7xl text-emerald-900">
                    <i class="fas fa-users-rectangle"></i>
                </div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-wider">စုစုပေါင်း အကျုံးဝင်တောင်သူ</p>
                <h3 class="text-3xl font-black text-slate-800 mt-3">၁,၂၅၀ <span
                        class="text-sm font-bold text-slate-400 ms-1">ဦး</span></h3>
                <div
                    class="mt-4 flex items-center gap-1.5 text-[11px] font-bold text-emerald-600 bg-emerald-50 w-max px-2.5 py-1 rounded-lg">
                    <i class="fas fa-arrow-trend-up"></i> +၁၂% တိုးတက်လာမှု
                </div>
            </div>

            <!-- Card 2: Today Loan Disbursed -->
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all relative overflow-hidden group">
                <div
                    class="absolute right-0 bottom-0 translate-x-4 translate-y-4 opacity-5 group-hover:scale-110 transition-all text-7xl text-emerald-900">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-wider">ယနေ့ ထုတ်ချေးပြီး ချေးငွေပမာဏ</p>
                <h3 class="text-3xl font-black text-emerald-700 mt-3">၄၅ <span
                        class="text-sm font-bold text-emerald-600 ms-1">သိန်း</span></h3>
                <div
                    class="mt-4 flex items-center gap-1.5 text-[11px] font-bold text-slate-500 bg-slate-50 w-max px-2.5 py-1 rounded-lg">
                    <i class="fas fa-circle-check"></i> လုပ်ငန်းစဉ်အောင်မြင်
                </div>
            </div>

            <!-- Card 3: Pending Repayments -->
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all relative overflow-hidden group">
                <div
                    class="absolute right-0 bottom-0 translate-x-4 translate-y-4 opacity-5 group-hover:scale-110 transition-all text-7xl text-amber-900">
                    <i class="fas fa-clock-rotate-left"></i>
                </div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-wider">ပြန်လည်ပေးဆပ်ရန် ကျန်ရှိသူ</p>
                <h3 class="text-3xl font-black text-amber-600 mt-3">၈၅ <span
                        class="text-sm font-bold text-amber-500 ms-1">ဦး</span></h3>
                <div
                    class="mt-4 flex items-center gap-1.5 text-[11px] font-bold text-amber-600 bg-amber-50 w-max px-2.5 py-1 rounded-lg">
                    <i class="fas fa-exclamation-triangle"></i> သက်တမ်းစေ့ရောက်ရန်နီးကပ်
                </div>
            </div>

            <!-- Card 4: Savings Accounts -->
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all relative overflow-hidden group">
                <div
                    class="absolute right-0 bottom-0 translate-x-4 translate-y-4 opacity-5 group-hover:scale-110 transition-all text-7xl text-blue-900">
                    <i class="fas fa-piggy-bank"></i>
                </div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-wider">တောင်သူ စုဆောင်းငွေစာရင်း</p>
                <h3 class="text-3xl font-black text-blue-600 mt-3">၃၄၈ <span
                        class="text-sm font-bold text-blue-400 ms-1">ခု</span></h3>
                <div
                    class="mt-4 flex items-center gap-1.5 text-[11px] font-bold text-blue-600 bg-blue-50 w-max px-2.5 py-1 rounded-lg">
                    <i class="fas fa-shield-halved"></i> လုံခြုံစိတ်ချရမှု ၁၀၀%
                </div>
            </div>
        </div>

        <!-- Charts Visual Dashboard Section -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 mb-10">

            <!-- Beautiful Bar Chart Card (Takes 3 Columns) -->
            <div
                class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 lg:col-span-3 flex flex-col justify-between">
                <div>
                    <h4 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-emerald-600"></i> လအလိုက် ချေးငွေပြန်လည်ကောက်ခံရရှိမှုနှုန်း
                    </h4>
                    <p class="text-[11px] font-semibold text-slate-400 mt-1">၂၀၂၆ ခုနှစ် ပထမသုံးလပတ် နှိုင်းယှဉ်ချက်ဇယား</p>
                </div>

                <!-- Graphic Simulated Bar View -->
                <div class="h-60 flex items-end gap-5 px-4 mt-8 border-b border-slate-100 pb-2">
                    <div
                        class="w-full bg-slate-50 hover:bg-emerald-50 h-[40%] rounded-xl transition-all cursor-pointer relative group flex flex-col justify-end border border-slate-100/50">
                        <span
                            class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] font-bold px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-all shadow-md z-10">၄၀%</span>
                        <div class="w-full bg-emerald-600/20 group-hover:bg-emerald-600 h-full rounded-xl transition-all">
                        </div>
                    </div>
                    <div
                        class="w-full bg-slate-50 hover:bg-emerald-50 h-[65%] rounded-xl transition-all cursor-pointer relative group flex flex-col justify-end border border-slate-100/50">
                        <span
                            class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] font-bold px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-all shadow-md z-10">၆၅%</span>
                        <div class="w-full bg-emerald-600/20 group-hover:bg-emerald-600 h-full rounded-xl transition-all">
                        </div>
                    </div>
                    <!-- Active Month Highlighted styling -->
                    <div
                        class="w-full bg-emerald-50 h-[92%] rounded-xl relative group flex flex-col justify-end border border-emerald-100 shadow-sm shadow-emerald-50">
                        <span
                            class="absolute -top-8 left-1/2 -translate-x-1/2 bg-emerald-700 text-white text-[10px] font-bold px-2 py-1 rounded-lg shadow-md z-10">၉၂%</span>
                        <div class="w-full bg-emerald-600 h-full rounded-xl"></div>
                    </div>
                    <div
                        class="w-full bg-slate-50 hover:bg-emerald-50 h-[55%] rounded-xl transition-all cursor-pointer relative group flex flex-col justify-end border border-slate-100/50">
                        <span
                            class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] font-bold px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-all shadow-md z-10">၅၅%</span>
                        <div class="w-full bg-emerald-600/20 group-hover:bg-emerald-600 h-full rounded-xl transition-all">
                        </div>
                    </div>
                </div>

                <!-- X-Axis Labels -->
                <div class="flex justify-between mt-3 px-2 text-xs font-bold text-slate-500">
                    <span>ဇန်နဝါရီ</span><span>ဖေဖော်ဝါရီ</span><span>မတ် (ယခုလ)</span><span>ဧပြီ</span>
                </div>
            </div>

            <!-- Beautiful Pie Chart Card (Takes 2 Columns) -->
            <div
                class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 lg:col-span-2 flex flex-col items-center justify-between">
                <div class="w-full text-left">
                    <h4 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-emerald-600"></i> စိုက်ပျိုးစရိတ်ချေးငွေ အမျိုးအစားအလိုက် ခွဲခြားမှု
                    </h4>
                    <p class="text-[11px] font-semibold text-slate-400 mt-1">အမျိုးအစားအလိုက် ရန်ပုံငွေခွဲဝေမှု Ratio</p>
                </div>

                <!-- Graphic Simulated Donut Pie Circle -->
                <div
                    class="my-6 relative w-40 h-40 rounded-full border-[18px] border-emerald-600 border-l-amber-400 border-b-blue-500 flex items-center justify-center bg-slate-50/50 shadow-inner">
                    <div class="text-center">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest leading-none">အချိုးအစား</p>
                        <p class="text-base font-black text-slate-800 mt-1">Ratio</p>
                    </div>
                </div>

                <!-- Custom Grid Legends -->
                <div class="grid grid-cols-1 gap-2 w-full text-xs font-bold text-slate-600 border-t border-slate-50 pt-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 bg-emerald-600 rounded-full"></span>
                            စပါးစိုက်ပျိုးစရိတ်</div>
                        <span class="text-slate-400 font-medium">၅၅%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 bg-amber-400 rounded-full"></span>
                            ဆီထွက်သီးနှံစရိတ်</div>
                        <span class="text-slate-400 font-medium">၂၅%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 bg-blue-500 rounded-full"></span>
                            အခြားဆောင်းသီးနှံ</div>
                        <span class="text-slate-400 font-medium">၂၀%</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
