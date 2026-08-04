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
                    မြန်မာ့လယ်ယာဖွံ့ဖြိုးရေးဘဏ် Hinthada နှင့် သက်ဆိုင်ရာဌာနများသို့ အောက်ပါအချက်အလက်များမှတစ်ဆင့်
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
                            <h2 class="text-2xl font-bold text-gray-800">ဘဏ်ရုံး</h2>
                        </div>

                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <i class="fas fa-map-marker-alt text-green-600 mt-1"></i>
                                <p class="text-gray-600 leading-relaxed">
                                    No. (240/A), Uyinmyout Block, Nat Maw Road, Hinthada 10061, Ayeyarwady Region, Myanmar
                                </p>
                            </div>
                            <div class="flex gap-4">
                                <i class="fas fa-phone-alt text-green-600 mt-1"></i>
                                <p class="text-gray-600 font-bold">044-2022817 </p>
                            </div>
                            <div class="flex gap-4">
                                <i class="fas fa-phone-alt text-green-600 mt-1"></i>
                                <p class="text-gray-600 font-bold">+95 44 2022817</p>
                            </div>
                            <div class="flex gap-4">
                                <i class="fas fa-envelope text-green-600 mt-1"></i>
                                <p class="text-gray-600 break-all">madb@mptmail.net.mm</p>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="lg:col-span-2">
                     <div class="rounded-3xl overflow-hidden shadow-lg h-64 bg-gray-200 border-4 border-white relative">

                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d950.5485719413981!2d95.4581424487186!3d17.640954762499845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c0c171958bcfe3%3A0xecbe8cb76867fb4c!2sMyanma%20Agriculture%20Bank!5e0!3m2!1sen!2smm!4v1785507000941!5m2!1sen!2smm" width="600" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin">
                        </iframe>
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
