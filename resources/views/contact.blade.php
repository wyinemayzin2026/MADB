@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <div class="bg-green-800 py-16 px-4 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <i class="fas fa-wheat-awn text-[200px] absolute -right-10 -bottom-10 rotate-12"></i>
            </div>
            <div class="max-w-7xl mx-auto text-center relative z-10">
                <h1 class="text-4xl md:text-5xl font-black text-white mb-4">ဆက်သွယ်ရန်</h1>
                <p class="text-green-100 text-lg max-w-2xl mx-auto">
                    မြန်မာ့လယ်ယာဖွံ့ဖြိုးရေးဘဏ် (ရုံးချုပ်) နှင့် သက်ဆိုင်ရာဌာနများသို့ အောက်ပါအချက်အလက်များမှတစ်ဆင့်
                    တိုက်ရိုက်ဆက်သွယ်နိုင်ပါသည်။
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 -mt-10 pb-20 mt-20">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-xl border-t-8 border-yellow-500">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-12 h-12 bg-green-100 text-green-700 rounded-2xl flex items-center justify-center text-xl">
                                <i class="fas fa-building"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">ဘဏ်ရုံးချုပ်</h2>
                        </div>

                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <i class="fas fa-map-marker-alt text-green-600 mt-1"></i>
                                <p class="text-gray-600 leading-relaxed">
                                    No.26/42 Pansodan Street, Kyauktadar Township, Yangon. Myanmar
                                </p>
                            </div>
                            <div class="flex gap-4">
                                <i class="fas fa-phone-alt text-green-600 mt-1"></i>
                                <p class="text-gray-600 font-bold">01-391342</p>
                            </div>
                            <div class="flex gap-4">
                                <i class="fas fa-envelope text-green-600 mt-1"></i>
                                <p class="text-gray-600 break-all">madb@mptmail.net.mm</p>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-gray-100 flex gap-4">
                            <a href="#"
                                class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center hover:scale-110 transition"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a href="#"
                                class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center hover:scale-110 transition"><i
                                    class="fas fa-globe"></i></a>
                        </div>
                    </div>

                    <div class="rounded-3xl overflow-hidden shadow-lg h-64 bg-gray-200 border-4 border-white relative">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3820.0!2d96.1!3d16.7!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTbCsDQyJzEwLjgiTiA5NiwzNicwMy42IkU!5e0!3m2!1sen!2smm!4v123456789"
                            class="absolute inset-0 w-full h-full border-0" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <h3 class="text-2xl font-bold text-green-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-sitemap"></i> ဌာနအလိုက် ဆက်သွယ်ရန်
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php
                            $departments = [
                                ['name' => 'စီမံရေးရာဌာန', 'phone' => '01-391342', 'email' => 'manage@madb.gov.mm', 'icon' => 'fa-user-tie', 'color' => 'blue'],
                                ['name' => 'နှစ်စဉ်ချေးငွေဌာန', 'phone' => '01-391343', 'email' => 'slcloan@madb.gov.mm', 'icon' => 'fa-calendar-check', 'color' => 'green'],
                                ['name' => 'ဖွံ့ဖြိုးရေးချေးငွေဌာန', 'phone' => '01-391344', 'email' => 'jicaloan@madb.gov.mm', 'icon' => 'fa-seedling', 'color' => 'emerald'],
                                ['name' => 'နည်းပညာဌာန', 'phone' => '01-391344', 'email' => 'itdept@madb.gov.mm', 'icon' => 'fa-laptop-code', 'color' => 'indigo'],
                                ['name' => 'ဝန်ထမ်းရေးရာဌာန', 'phone' => '01-391344', 'email' => 'jicaloan@madb.gov.mm', 'icon' => 'fa-users-cog', 'color' => 'orange']
                            ];
                        @endphp

                        @foreach($departments as $dept)
                            <div
                                class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300">
                                <div class="flex items-center gap-4 mb-4">
                                    <div
                                        class="w-12 h-12 bg-gray-50 text-green-600 rounded-xl flex items-center justify-center text-xl border border-green-50">
                                        <i class="fas {{ $dept['icon'] }}"></i>
                                    </div>
                                    <h4 class="font-bold text-gray-800">{{ $dept['name'] }}</h4>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center gap-3 text-gray-600">
                                        <i class="fas fa-phone-alt w-4"></i>
                                        <span>{{ $dept['phone'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-gray-600">
                                        <i class="fas fa-envelope w-4"></i>
                                        <span class="break-all">{{ $dept['email'] }}</span>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Custom Font Fix for Myanmar Text */
        body {
            font-family: 'Pyidaungsu', sans-serif;
        }
    </style>
@endsection
