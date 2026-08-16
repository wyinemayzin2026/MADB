@extends('layouts.staff_app')

@section('content')
<div class="p-6 max-w-7xl mx-auto" x-data="{ openModal: false, activeComplaint: null }">

    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">📩 တိုင်ကြားစာများ စာရင်း</h1>
            <p class="text-xs text-slate-500 mt-1">တိုင်ကြားစာများကို စိစစ်ရန်၊ အခြေအနေ ပြောင်းရန်နှင့် အီးမေးလ် ပြန်လည် အကြောင်းပြန်ရန်</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 text-sm font-semibold rounded-r-xl">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- Complaints Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase font-bold">
                        <th class="p-4">စဉ်</th>
                        <th class="p-4">ပေးပို့သူ အီးမေးလ်</th>
                        <th class="p-4">လက်ခံသူ အီးမေးလ်</th>
                        <th class="p-4">ခေါင်းစဉ် (Subject)</th>
                        <th class="p-4 text-center">အခြေအနေ (Status)</th>
                        <th class="p-4">ပေးပို့သည့်ရက်</th>
                        <th class="p-4 text-center">လုပ်ဆောင်ချက်</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($complaints as $index => $item)
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="p-4 font-semibold text-slate-500">{{ $complaints->firstItem() + $index }}</td>
                            <td class="p-4 font-semibold text-slate-800">{{ $item->from_email }}</td>
                            <td class="p-4 text-slate-500">{{ $item->to_email }}</td>
                            <td class="p-4 font-medium text-slate-800 max-w-xs truncate">{{ $item->subject }}</td>
                            <td class="p-4 text-center">
                                @if($item->status == 'resolved')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 font-bold rounded-full text-[11px]">
                                        ✓ ဖြေရှင်းပြီး
                                    </span>
                                @elseif($item->status == 'rejected')
                                    <span class="px-3 py-1 bg-red-100 text-red-700 font-bold rounded-full text-[11px]">
                                        ✕ ငြင်းပယ်ခဲ့သည်
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 font-bold rounded-full text-[11px]">
                                        ⏳ စိစစ်ဆဲ (Pending)
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-slate-500">{{ $item->created_at->format('Y-m-d H:i A') }}</td>
                            <td class="p-4 text-center">
                                <button
                                    @click="activeComplaint = {{ json_encode($item) }}; openModal = true"
                                    class="px-3 py-1.5 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700 transition-all text-xs">
                                    <i class="fas fa-eye me-1"></i> ကြည့်မည် / အကြောင်းပြန်မည်
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">
                                တိုင်ကြားစာများ မရှိသေးပါ။
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $complaints->links() }}
        </div>
    </div>

    <!-- POP-UP MODAL (Detail & Reply Action) -->
    <div x-show="openModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden border border-slate-100" @click.away="openModal = false">

            <!-- Modal Header -->
            <div class="px-6 py-4 bg-slate-800 text-white flex justify-between items-center">
                <h3 class="font-bold text-sm flex items-center gap-2">
                    <i class="fas fa-envelope-open-text text-emerald-400"></i> တိုင်ကြားစာ အသေးစိတ်နှင့် အကြောင်းပြန်ရန်
                </h3>
                <button @click="openModal = false" class="text-slate-400 hover:text-white transition-all text-lg font-bold">&times;</button>
            </div>

            <div class="p-6 max-h-[80vh] overflow-y-auto space-y-4" x-if="activeComplaint">

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200 text-xs">
                    <div>
                        <span class="text-slate-400 block font-semibold mb-0.5">တိုင်ကြားသူ (From):</span>
                        <span class="font-bold text-slate-700" x-text="activeComplaint.from_email"></span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-semibold mb-0.5">လက်ခံသူ (To):</span>
                        <span class="font-bold text-slate-700" x-text="activeComplaint.to_email"></span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-slate-400 block font-semibold mb-0.5">ခေါင်းစဉ် (Subject):</span>
                        <span class="font-bold text-slate-800" x-text="activeComplaint.subject"></span>
                    </div>
                </div>

                <!-- Complaint Body -->
                <div>
                    <h4 class="text-xs font-bold text-slate-700 mb-1">အကြောင်းအရာ အပြည့်အစုံ:</h4>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 leading-relaxed whitespace-pre-line" x-text="activeComplaint.body"></div>
                </div>

                <!-- Action Form -->
                <form :action="'/staff/complaints/' + activeComplaint.id + '/status'" method="POST" class="pt-3 border-t border-slate-200 space-y-4">
                    @csrf

                    <!-- Status Selection Buttons -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">အခြေအနေ သတ်မှတ်ရန် (Select Action Status):</label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="cursor-pointer border border-slate-200 rounded-xl p-3 flex items-center justify-center gap-2 hover:bg-slate-50 font-bold text-xs text-slate-600 has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50 has-[:checked]:text-amber-700">
                                <input type="radio" name="status" value="pending" class="hidden" x-model="activeComplaint.status">
                                ⏳ ဆိုင်းငံ့ (Pending)
                            </label>
                            <label class="cursor-pointer border border-slate-200 rounded-xl p-3 flex items-center justify-center gap-2 hover:bg-slate-50 font-bold text-xs text-slate-600 has-[:checked]:border-green-600 has-[:checked]:bg-green-50 has-[:checked]:text-green-700">
                                <input type="radio" name="status" value="resolved" class="hidden" x-model="activeComplaint.status">
                                ✓ ဖြေရှင်းပြီး (Resolve)
                            </label>
                            <label class="cursor-pointer border border-slate-200 rounded-xl p-3 flex items-center justify-center gap-2 hover:bg-slate-50 font-bold text-xs text-slate-600 has-[:checked]:border-red-600 has-[:checked]:bg-red-50 has-[:checked]:text-red-700">
                                <input type="radio" name="status" value="rejected" class="hidden" x-model="activeComplaint.status">
                                ✕ ငြင်းပယ်မည် (Reject)
                            </label>
                        </div>
                    </div>

                    <!-- Email Reply Textarea -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            တိုင်ကြားသူထံ အီးမေးလ် ပြန်လည် အကြောင်းပြန်စာ:
                        </label>
                        <textarea name="reply_note" rows="3"
                            placeholder="တိုင်ကြားသူထံ ပြန်လည် ပေးပို့လိုသော စာလွှာ အကြောင်းအရာကို ဤနေရာတွင် ရေးပါ..."
                            class="w-full text-xs p-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-600 focus:bg-white transition-all"></textarea>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="openModal = false" class="px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-300">
                            ပိတ်မည်
                        </button>
                        <button type="submit" class="px-5 py-2 bg-emerald-600 text-white font-bold rounded-xl text-xs hover:bg-emerald-700 shadow-md">
                            အခြေအနေ ပြောင်းရန် & Email ပို့မည်
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
