@extends('layouts.app')

@section('content')
    <div class="min-h-[calc(100vh-80px)] flex items-center justify-center p-4 md:p-10 bg-slate-50">

        <div class="bg-white rounded-[40px] shadow-[0_20px_50px_rgba(15,23,42,0.08)] border border-slate-100 max-w-5xl w-full grid md:grid-cols-12 overflow-hidden min-h-[600px]">

            <div class="hidden md:flex md:col-span-5 bg-gradient-to-br from-emerald-600 via-emerald-700 to-green-800 p-12 flex-col justify-between text-white relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-60 h-60 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute -left-20 -bottom-20 w-65 h-65 bg-white/5 rounded-full blur-3xl"></div>

                <div class="flex items-center gap-3 relative z-10">
                    <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20">
                        <i class="fas fa-university text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-xl tracking-wide">MADB System</h3>
                        <p class="text-[10px] text-emerald-200 tracking-wider font-semibold uppercase">Digital Banking</p>
                    </div>
                </div>

                <div class="space-y-4 relative z-10 my-auto">
                    <h2 class="text-3xl leading-snug font-bold">မြန်မာလယ်ယာ<br>ဖွံ့ဖြိုးရေးဘဏ်</h2>
                    <div class="h-1 w-16 bg-emerald-400 rounded-full"></div>
                    <p class="text-emerald-100/80 text-sm leading-relaxed font-light">တောင်သူလယ်သမားများနှင့် ကျေးလက်ပြည်သူများ၏ လူမှုစီးပွားဘဝ ဖွံ့ဖြိုးတိုးတက်ရေးအတွက် ယုံကြည်စိတ်ချရသော ဘဏ်လုပ်ငန်းဝန်ဆောင်မှု။</p>
                </div>

                <div class="text-xs text-emerald-200/50 relative z-10">
                    &copy; {{ date('Y') }} MADB. All Rights Reserved.
                </div>
            </div>

            <div class="col-span-12 md:col-span-7 p-8 sm:p-12 md:p-16 flex flex-col justify-center">

                <div class="flex md:hidden items-center gap-2.5 mb-8 justify-center">
                    <div class="w-11 h-11 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200 text-white">
                        <i class="fas fa-university text-lg"></i>
                    </div>
                    <div class="text-left">
                        <h3 class="font-bold text-lg text-slate-800 leading-tight">MADB</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">မြန်မာလယ်ယာဖွံ့ဖြိုးရေးဘဏ်</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">ချေးငွေလျှောက်ထားသူ လော့ဂ်အင်</h1>
                    <p class="text-slate-400 text-sm mt-1">ရှေ့ဆက်ရန် သင်၏ မှတ်ပုံတင်နှင့် လျှို့ဝှက်နံပါတ်ကို ရိုက်ထည့်ပါ</p>
                    <p class="text-slate-400 text-sm mt-1">ဦးစွာ ပထမ ငွေစုစာရင်းအကောင့်ဖွင့်ထားရန် လိုအပ်ပါသည်</p>
                </div>

                @error('login_error')
                    <div class="bg-rose-50 border border-rose-200 text-rose-600 p-4 rounded-2xl text-xs font-bold mb-6 flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-base"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror

                <form method="POST" action="{{ route('borrower.login.submit') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">မှတ်ပုံတင်နံပါတ် (NRC)</label>
                        <div class="grid grid-cols-12 gap-2 bg-slate-50 p-2.5 border border-slate-200 rounded-2xl focus-within:ring-2 focus-within:ring-emerald-500 focus-within:border-emerald-500 focus-within:bg-white transition-all">

                            <div class="col-span-3">
                                <select id="nrc_state" name="nrc_state" required
                                    class="w-full bg-transparent outline-none text-sm font-bold text-slate-700 cursor-pointer p-1">
                                    <option value="" disabled selected>၁၄</option>
                                    @for ($i = 1; $i <= 14; $i++)
                                        <option value="{{ $i }}" {{ old('nrc_state') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-span-1 text-center text-slate-400 font-bold self-center">/</div>

                            <div class="col-span-4">
                                <select id="nrc_township" name="nrc_township" required disabled
                                    class="w-full bg-transparent outline-none text-sm font-bold text-slate-700 cursor-pointer p-1">
                                    <option value="">Township</option>
                                </select>
                            </div>

                            <div class="col-span-4">
                                <select id="nrc_type" name="nrc_type" required
                                    class="w-full bg-transparent outline-none text-sm font-bold text-slate-700 cursor-pointer p-1">
                                    <option value="(N)" {{ old('nrc_type') == '(N)' ? 'selected' : '' }}>(N)</option>
                                    <option value="(P)" {{ old('nrc_type') == '(P)' ? 'selected' : '' }}>(P)</option>
                                    <option value="(E)" {{ old('nrc_type') == '(E)' ? 'selected' : '' }}>(E)</option>
                                    <option value="(T)" {{ old('nrc_type') == '(T)' ? 'selected' : '' }}>(T)</option>
                                </select>
                            </div>

                            <div class="col-span-12 border-t border-slate-200 mt-2.5 pt-2.5 px-1 flex items-center gap-2">
                                <i class="fas fa-id-card text-slate-400 text-sm"></i>
                                <input type="text" id="nrc_digits" name="nrc_digits" placeholder="370020" required maxlength="6"
                                    value="{{ old('nrc_digits') }}"
                                    class="w-full bg-transparent outline-none text-sm font-bold tracking-wider text-slate-800 placeholder-slate-400">
                            </div>
                        </div>
                        @error('nrc_number') <p class="text-rose-500 text-xs mt-1.5 ml-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">လျှို့ဝှက်နံပါတ် (Password)</label>
                        <div class="relative group">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-600 transition-colors"></i>
                            <input type="password" id="password" name="password" placeholder="••••••••" required
                                class="w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                            <button type="button" id="toggle-password" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password') <p class="text-rose-500 text-xs mt-1.5 ml-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl text-sm tracking-wide transition-all shadow-lg shadow-emerald-100 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>စနစ်ထဲသို့ဝင်ရန်</span>
                        </button>
                    </div>

                    <div class="text-center pt-4 border-t border-slate-100">
                        <p class="text-xs text-slate-400 font-medium">ချေးငွေလျှောက်ထားရန် အကောင့်မရှိသေးပါက <br class="sm:hidden"> ဘဏ်ခွဲတွင် အရင်စာရင်းပေးသွင်းပါ</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function () {
            const nrcData = {
                '1': ['မကန', 'ပသန', 'ဝမန', 'ဗမန', 'ကမန', 'ဟခန'], // ကချင် (မြစ်ကြီးနား၊ ပူတာအို စသည်)
                '2': ['လကန', 'မဆန', 'ဒမဆ', 'ဖဆန'],             // ကယား (လွိုင်ကော် စသည်)
                '3': ['ဘအန', 'ကကရ', 'ဖအန', 'လှက', 'ကတန'],       // ကရင် (ဘားအံ၊ ကော့ကရိတ် စသည်)
                '4': ['ဟခန', 'တတန', 'ဖလန', 'မတန', 'ကပတ'],       // ချင်း (ဟားခါး၊ တီးတိန် စသည်)
                '5': ['စကန', 'ရဥန', 'ကနန', 'ကလေး', 'တမု', 'မမန'], // စစ်ကိုင်း (မမန = မြင်းမူ ပါဝင်လာပါပြီ)
                '6': ['ထဝန', 'မြန', 'လလန', 'ကသန', 'ပလန'],       // တနင်္သာရီ (ထားဝယ်၊ မြိတ် စသည်)
                '7': ['တငန', 'ညလန', 'ပခန', 'ရမသ', 'ကတန', 'တရန'], // ပဲခူး (တောင်ငူ၊ ပြည် စသည်)
                '8': ['မထန', 'နမန', 'ပကက', 'အောင်လံ', 'ချောက်', 'တမဒ'], // မကွေး
                '9': ['မရန', 'တသန', 'ညဥန', 'ပဥလ', 'ကျောက်ဆည်', 'မတရ', 'ရမသ'], // မန္တလေး
                '10': ['မဒန', 'သထန', 'ကမရ', 'ရေး', 'ဘလန', 'သဇန'], // မွန် (မော်လမြိုင်၊ သထုံ စသည်)
                '11': ['စတန', 'တသန', 'မဥန', 'ပတန', 'ကသန', 'မဂဗ'], // ရခိုင် (စစ်တွေ၊ သံတွဲ စသည်)
                '12': ['ကမရ', 'တမန', 'လကန', 'ဥကတ', 'ဗဟန', 'ဒဂုံ', 'မဂဒ', 'စကန', 'ရကန', 'ကတတ'], // ရန်ကုန်
                '13': ['တကန', 'လရှန', 'တယန', 'ဟပန', 'ကကန', 'မကန', 'နဆန'], // ရှမ်း (တောင်ကြီး၊ လားရှိုး စသည်)
                '14': ['မမန', 'ဖပန', 'ပသန', 'ဟသတ', 'ဝခမ', 'ရဒန', 'အမန', 'ကလန', 'ကခန'] // ဧရာဝတီ (ပုသိမ်၊ ဟင်္သာတ စသည်)
            };

            $('#nrc_state').on('change', function() {
                var state = $(this).val();
                updateTownshipDropdown(state, '');
            });

            function updateTownshipDropdown(state, selectedTownship) {
                var $townshipSelect = $('#nrc_township');
                $townshipSelect.empty().append('<option value="">Township</option>');

                if (state && nrcData[state]) {
                    $townshipSelect.prop('disabled', false);
                    nrcData[state].forEach(function(township) {
                        var selected = (township === selectedTownship) ? 'selected' : '';
                        $townshipSelect.append(`<option value="${township}" ${selected}>${township}</option>`);
                    });
                } else {
                    $townshipSelect.prop('disabled', true);
                }
            }

            @if(old('nrc_state'))
                $('#nrc_state').val("{{ old('nrc_state') }}");
                updateTownshipDropdown("{{ old('nrc_state') }}", "{{ old('nrc_township') }}");
            @endif

            $('#toggle-password').on('click', function() {
                var $input = $('#password');
                var $icon = $(this).find('i');
                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');
                    $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $input.attr('type', 'password');
                    $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
@endsection
