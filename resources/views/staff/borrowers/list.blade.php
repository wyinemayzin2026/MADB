@extends('layouts.staff_app')

@section('content')
    <style>
        @font-face {
            font-family: 'Pyidaungsu';
            src: url('https://cdn.jsdelivr.net/gh/googlefonts/pyidaungsu@master/fonts/ttf/Pyidaungsu-Regular.ttf') format('truetype');
        }

        body {
            font-family: 'Pyidaungsu', sans-serif !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <div class="p-6 lg:p-10 bg-[#f0f4f8] min-h-screen">

        <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-8">
            <div>
                <h2 class="text-3xl text-indigo-900 text-[#0f172a] leading-tight uppercase">ငွေစုစာရင်းအကောင့်များ</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-2 h-2 bg-indigo-600 rounded-full animate-pulse"></span>
                    <p class="text-slate-500 text-[10px] text-indigo-900 tracking-[1px] uppercase">ဗဟိုစီမံခန့်ခွဲမှုစနစ်
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 items-center">
                <form action="{{ route('borrowers.list') }}" method="GET" class="flex gap-3">
                    <div class="relative group">
                        <i
                            class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="အမည်ဖြင့်ရှာဖွေရန်..."
                            class="pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-[#0f172a] focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all w-64 shadow-sm">
                    </div>
                </form>

                <div id="exportButtons" class="flex gap-2"></div>

                <button id="btn-create"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-emerald-200">
                    <i class="fas fa-plus mr-2"></i> အကောင့်အသစ်ဖွင့်ရန်
                </button>
            </div>
        </div>

        <div
            class="bg-white rounded-[40px] shadow-[0_10px_40px_rgba(15,23,42,0.05)] border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto p-2">
                <table id="accountTable" class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-50">
                            <th class="px-6 py-6 text-[10px] text-indigo-700 text-slate-400 uppercase tracking-[2px]">
                                နာမည်အပြည့်</th>
                            <th class="px-6 py-6 text-[10px] text-indigo-700 text-slate-400 uppercase tracking-[2px]">
                                မှတ်ပုံတင်နံပါတ်</th>
                            <th class="px-6 py-6 text-[10px] text-indigo-700 text-slate-400 uppercase tracking-[2px]">
                                ဆက်သွယ်ရန်ဖုန်း</th>
                            <th class="px-6 py-6 text-[10px] text-indigo-700 text-slate-400 uppercase tracking-[2px]">Email
                                Address</th>
                            <th class="px-6 py-6 text-[10px] text-indigo-700 text-slate-400 uppercase tracking-[2px]">
                                မွေးနေ့</th>
                            <th class="px-6 py-6 text-[10px] text-indigo-700 text-slate-400 uppercase tracking-[2px]">ကျား/မ
                            </th>
                            <th class="px-6 py-6 text-[10px] text-indigo-700 text-slate-400 uppercase tracking-[2px]">
                                နေရပ်လိပ်စာ</th>
                            <th
                                class="px-6 py-6 text-[10px] text-indigo-700 text-slate-400 uppercase tracking-[2px] no-export">
                                ပြင်ဆင်ချက်</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($accounts as $account)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-6 text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    {{ $account->full_name }}</td>
                                <td class="px-6 py-6 text-xs font-bold text-slate-600 tracking-wider">{{ $account->nrc_number }}
                                </td>
                                <td class="px-6 py-6 text-xs font-bold text-slate-600 tracking-wider">
                                    {{ $account->phone_number }}</td>
                                <td class="px-6 py-6 text-xs font-bold text-slate-600 tracking-wider">
                                    {{ $account->email ?? '-' }}</td>
                                <td class="px-6 py-6 text-xs font-bold text-slate-400 tracking-widest">
                                    {{ $account->date_of_birth }}</td>
                                <td class="px-6 py-6 text-xs font-bold text-slate-600">
                                    {{ $account->gender == 'male' ? 'ကျား' : ($account->gender == 'female' ? 'မ' : 'အခြား') }}
                                </td>
                                <td class="px-6 py-6 text-xs font-bold text-slate-600 truncate max-w-[150px]">
                                    {{ $account->address ?? '-' }}</td>
                                <td class="px-6 py-6 no-export">
                                    <div class="flex items-center gap-2">
                                        <button
                                            class="btn-edit text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-xl"
                                            data-id="{{ $account->id }}" data-full_name="{{ $account->full_name }}"
                                            data-nrc_number="{{ $account->nrc_number }}"
                                            data-phone_number="{{ $account->phone_number }}" data-email="{{ $account->email }}"
                                            data-date_of_birth="{{ $account->date_of_birth }}"
                                            data-gender="{{ $account->gender }}" data-address="{{ $account->address }}"> <i
                                                class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('accounts.destroy', $account->id) }}" method="POST"
                                            class="delete-form inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn-delete text-rose-600 hover:text-rose-900 bg-rose-50 p-2 rounded-xl">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 px-6">
            {{ $accounts->links() }}
        </div>
    </div>

    <div id="account-modal"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-xl transform transition-all">
            <div class="p-6 border-b flex justify-between items-center">
                <h3 id="modal-title" class="text-lg font-bold text-slate-800">ငွေစုစာရင်းအကောင့်အသစ်ဖွင့်ရန်</h3>
                <button type="button" class="close-modal text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="account-form" method="POST" action="{{ route('accounts.store') }}" class="p-6 space-y-4">
                @csrf
                <div id="method-container"></div>
                <input type="hidden" id="account-id" name="id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-slate-700">နာမည်အပြည့်</label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required
                            class="w-full p-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                        @error('full_name') <p class="text-rose-500 text-xs mt-1 error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold mb-1 text-slate-700">မှတ်ပုံတင်နံပါတ်</label>
                        <div class="grid grid-cols-12 gap-2">
                            <div class="col-span-3 md:col-span-2">
                                <select id="nrc_state" name="nrc_state" required
                                    class="w-full p-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm font-bold text-slate-700 bg-white">
                                    <option value="" disabled selected>ရွေးရန်</option>
                                    @for ($i = 1; $i <= 14; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-span-1 text-center self-center font-bold text-slate-500">/</div>

                            <div class="col-span-4 md:col-span-3">
                                <select id="nrc_township" name="nrc_township" required disabled
                                    class="w-full p-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm font-bold text-slate-700 bg-white">
                                    <option value="">Township</option>
                                </select>
                            </div>

                            <div class="col-span-4 md:col-span-3">
                                <select id="nrc_type" name="nrc_type" required
                                    class="w-full p-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm font-bold text-slate-700 bg-white">
                                    <option value="(N)">(N)</option>
                                    <option value="(P)">(P)</option>
                                    <option value="(E)">(E)</option>
                                    <option value="(T)">(T)</option>
                                </select>
                            </div>

                            <div class="col-span-12 md:col-span-4">
                                <input type="text" id="nrc_digits" name="nrc_digits" placeholder="370020" required
                                    value="{{ old('nrc_digits') }}" maxlength="6"
                                    class="w-full p-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm font-bold tracking-wider">
                            </div>
                        </div>
                        @error('nrc_number') <p class="text-rose-500 text-xs mt-1 error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1 text-slate-700">ဆက်သွယ်ရန်ဖုန်း</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                            class="w-full p-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                        @error('phone_number') <p class="text-rose-500 text-xs mt-1 error-msg">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-slate-700">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full p-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                        @error('email') <p class="text-rose-500 text-xs mt-1 error-msg">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-slate-700">မွေးနေ့</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}"
                            required
                            class="w-full p-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                        @error('date_of_birth') <p class="text-rose-500 text-xs mt-1 error-msg">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-slate-700">ကျား/မ</label>
                        <select id="gender" name="gender" required
                            class="w-full p-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ကျား</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>မ</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>အခြား</option>
                        </select>
                        @error('gender') <p class="text-rose-500 text-xs mt-1 error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label id="lbl-password" class="block text-sm font-semibold mb-1 text-slate-700">လျှို့ဝှက်နံပါတ်
                            (Password)</label>
                        <input type="password" id="password" name="password"
                            class="w-full p-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                        @error('password') <p class="text-rose-500 text-xs mt-1 error-msg">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-slate-700">လျှို့ဝှက်နံပါတ်အတည်ပြုခြင်း</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full p-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold mb-1 text-slate-700">နေရပ်လိပ်စာ</label>
                        <textarea id="address" name="address" required rows="2"
                            class="w-full p-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('address') }}</textarea>
                        @error('address') <p class="text-rose-500 text-xs mt-1 error-msg">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button"
                        class="close-modal bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl font-semibold">ပယ်ဖျက်မည်</button>
                    <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl font-semibold">သိမ်းဆည်းမည်</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            $('#nrc_state').on('change', function () {
                var state = $(this).val();
                updateTownshipDropdown(state, '');
            });

            function updateTownshipDropdown(state, selectedTownship) {
                var $townshipSelect = $('#nrc_township');
                $townshipSelect.empty().append('<option value="">Township</option>');

                if (state && nrcData[state]) {
                    $townshipSelect.prop('disabled', false);
                    nrcData[state].forEach(function (township) {
                        var selected = (township === selectedTownship) ? 'selected' : '';
                        $townshipSelect.append(`<option value="${township}" ${selected}>${township}</option>`);
                    });
                } else {
                    $townshipSelect.prop('disabled', true);
                }
            }

            // Edit Action Function
            $('.btn-edit').on('click', function () {
                resetForm();
                var id = $(this).data('id');
                $('#modal-title').text('အကောင့်အချက်အလက်ပြင်ဆင်ရန်');

                // ပြင်ဆင်ချိန်တွင် password အသစ်ရိုက်ထည့်ရန်မလိုကြောင်း မှတ်ချက်ပေးခြင်း
                $('#lbl-password').text('လျှို့ဝှက်နံပါတ်အသစ် (မပြောင်းလဲက ချန်ထားရန်)');
                $('#password').prop('required', false);

                var updateUrl = "{{ route('accounts.update', ':id') }}".replace(':id', id);
                $('#account-form').attr('action', updateUrl);
                $('#method-container').html('@method("PUT")');

                $('#account-id').val(id);
                $('#full_name').val($(this).data('full_name'));
                $('#phone_number').val($(this).data('phone_number'));
                $('#email').val($(this).data('email'));
                $('#gender').val($(this).data('gender'));
                $('#address').val($(this).data('address'));

                var dob = $(this).data('date_of_birth');
                if (dob) {
                    $('#date_of_birth').val(dob.split(' ')[0]);
                }

                var fullNrc = $(this).data('nrc_number');
                if (fullNrc && fullNrc.includes('/') && fullNrc.includes(')')) {
                    var parts = fullNrc.split('/');
                    var state = parts[0];

                    var remaining = parts[1];
                    var typeIndex = remaining.indexOf('(');
                    var closeTypeIndex = remaining.indexOf(')');

                    var township = remaining.substring(0, typeIndex);
                    var nrcType = remaining.substring(typeIndex, closeTypeIndex + 1);
                    var digits = remaining.substring(closeTypeIndex + 1);

                    $('#nrc_state').val(state);
                    $('#nrc_type').val(nrcType);
                    $('#nrc_digits').val(digits);

                    updateTownshipDropdown(state, township);
                }

                $('#account-modal').removeClass('hidden');
            });

            // Datatable Configurations
            var table = $('#accountTable').DataTable({
                paging: false,
                info: false,
                searching: false,
                ordering: true,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
                        className: 'bg-white text-black px-6 py-3.5 rounded-2xl text-[10px] text-indigo-700 tracking-widest hover:bg-slate-800 hover:text-white transition-all border-none shadow-lg shadow-slate-200',
                        exportOptions: { columns: ':not(.no-export)' }
                    }
                ]
            });
            table.buttons().container().appendTo('#exportButtons');

            // Open Create Modal
            $('#btn-create').on('click', function () {
                resetForm();
                $('#modal-title').text('ငွေစုစာရင်းအကောင့်အသစ်ဖွင့်ရန်');
                $('#lbl-password').text('လျှို့ဝှက်နံပါတ် (Password)');
                $('#password').prop('required', true); // ဒေတာအသစ်ဖွင့်ချိန်တွင် မဖြစ်မနေလိုအပ်ပါသည်
                $('#account-form').attr('action', "{{ route('accounts.store') }}");
                $('#method-container').html('');
                $('#account-modal').removeClass('hidden');
            });

            $('.close-modal').on('click', function () {
                $('#account-modal').addClass('hidden');
                resetForm();
            });

            $('.btn-delete').on('click', function (e) {
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'ပယ်ဖျက်မည်လား?',
                    text: "ဤအကောင့်စာရင်းကို ဖျက်ရန် သေချာပါသလား?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#0f172a',
                    confirmButtonText: 'သေချာသည်',
                    cancelButtonText: 'မလုပ်တော့ပါ'
                }).then((result) => {
                    if (result.isConfirmed) { form.submit(); }
                });
            });

            @if($errors->any())
                $('#account-modal').removeClass('hidden');
                @if(old('id'))
                    var id = "{{ old('id') }}";
                    var updateUrl = "{{ route('accounts.update', ':id') }}".replace(':id', id);
                    $('#account-form').attr('action', updateUrl);
                    $('#method-container').html('@method("PUT")');
                    $('#modal-title').text('အကောင့်အချက်အလက်ပြင်ဆင်ရန်');
                    $('#lbl-password').text('လျှို့ဝှက်နံပါတ်အသစ် (မပြောင်းလဲက ချန်ထားရန်)');
                    $('#password').prop('required', false);

                    @if(old('nrc_state'))
                        updateTownshipDropdown("{{ old('nrc_state') }}", "{{ old('nrc_township') }}");
                    @endif
                @else
                    $('#lbl-password').text('လျှို့ဝှက်နံပါတ် (Password)');
                    $('#password').prop('required', true);
                @endif
            @endif

            function resetForm() {
                $('#account-form')[0].reset();
                $('#account-id').val('');
                $('.error-msg').remove();
                $('#nrc_township').empty().append('<option value="">Township</option>').prop('disabled', true);
            }
        });
    </script>
@endsection

