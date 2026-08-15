@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-8">

        <!-- Header -->
        <div class="border-b border-slate-100 pb-4 mb-6">
            <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                📩 တိုင်ကြားစာ ပေးပို့ရန် Page
            </h2>
            <p class="text-xs text-gray-500 mt-1">
                သင့်တွင် အဆင်မပြေမှုများ ရှိပါက အောက်ပါ ဖောင်တွင် ဖြည့်သွင်း၍ ပေးပို့နိုင်ပါသည်။
            </p>
        </div>

        <!-- Success Message Alert -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-600 p-4 rounded-r-xl flex items-center justify-between">
                <div class="flex items-center gap-2 text-green-800 text-sm font-semibold">
                    <span>✅ {{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Global Error Alert -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                <p class="text-sm font-bold text-red-800 mb-1">အချက်အလက်များ လွဲမှားနေပါသည် -</p>
                <ul class="list-disc list-inside text-xs text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Complaint Form -->
        <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Hidden Auto-filled Emails -->
            <input type="hidden" name="from_email" value="{{ Auth::guard('borrower')->check() ? Auth::guard('borrower')->user()->email : '' }}">
            <input type="hidden" name="to_email" value="{{ $adminEmail }}">

            <!-- Subject -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">ခေါင်းစဉ် <span class="text-red-500">*</span></label>
                <input type="text" name="subject" required
                    value="{{ old('subject') }}"
                    placeholder="တိုင်ကြားစာ ခေါင်းစဉ် ရေးပါ..."
                    class="w-full text-xs p-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-green-600 focus:bg-white transition-all">
            </div>

            <!-- Body -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">အကြောင်းအရာ<span class="text-red-500">*</span></label>
                <textarea name="body" rows="6" required
                    placeholder="တိုင်ကြားလိုသည့် အကြောင်းအရာ အပြည့်အစုံ ရေးသားပါ..."
                    class="w-full text-xs p-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-green-600 focus:bg-white transition-all">{{ old('body') }}</textarea>
            </div>

            <!-- Images Upload -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">ပုံစံများ/သက်သေခံပုံများ ပူးတွဲရန်</label>
                <input type="file" name="images[]" multiple accept="image/*"
                    class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition-all cursor-pointer border border-slate-200 rounded-xl p-1 bg-slate-50">
            </div>

            <!-- Buttons -->
            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ url('/') }}"
                    class="px-5 py-2.5 bg-slate-200 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-300 transition-all">
                    မလုပ်တော့ပါ
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-green-700 text-white text-xs font-bold rounded-xl hover:bg-green-800 transition-all shadow-md">
                    ပေးပို့မည်
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
