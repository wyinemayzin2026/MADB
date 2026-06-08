@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 p-6">
            <div class="flex flex-col sm:flex-row justify-between items-center border-b border-gray-200 pb-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">📋 မိမိ၏ ချေးငွေလျှောက်လွှာ မှတ်တမ်းများ</h2>
                    <p class="text-sm text-gray-500 mt-1">သင်လျှောက်ထားခဲ့ဖူးသော စိုက်ပျိုးစရိတ်ချေးငွေစာရင်း အပြည့်အစုံ</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('borrower.loan') }}"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-4 rounded-lg shadow text-sm transition">
                        <i class="fa-solid fa-plus mr-1"></i> ချေးငွေအသစ် လျှောက်မည်
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl p-1">
                <table id="loanTable" class="w-full text-sm text-left text-gray-600 border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-gray-700 font-bold border-b border-gray-200 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">အလုပ်အကိုင်</th>
                            <th class="px-4 py-3">ရာသီ / ဧက</th>
                            <th class="px-4 py-3">စုစုပေါင်းချေးငွေ</th>
                            <th class="px-4 py-3">လျှောက်ထားသည့်နေ့</th>
                            <th class="px-4 py-3 text-center">အခြေအနေ (Status)</th>
                            <th class="px-4 py-3 text-center">လုပ်ဆောင်ချက်</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($loans as $loan)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-4 font-bold text-gray-900">#{{ $loan->id }}</td>
                                <td class="px-4 py-4 font-medium text-gray-800">{{ $loan->occupation }}</td>
                                <td class="px-4 py-4">
                                    @if($loan->season_type == 'rainy')
                                        <span class="text-green-700 bg-green-50 px-2 py-0.5 rounded-md text-xs font-bold">🌧️
                                            မိုးသီးနှံ</span>
                                    @else
                                        <span class="text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md text-xs font-bold">❄️
                                            ဆောင်းသီးနှံ</span>
                                    @endif
                                    <span class="ml-1 text-gray-500">({{ $loan->acres }} ဧက)</span>
                                </td>
                                <td class="px-4 py-4 font-bold text-green-600 text-base">
                                    {{ number_format($loan->total_amount) }} <span
                                        class="text-xs text-gray-400 font-normal">ကျပ်</span>
                                </td>
                                <td class="px-4 py-4 text-gray-500 text-xs">{{ $loan->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-4 text-center">
                                    @if($loan->status == 'pending')
                                        <span class="px-3 py-1 text-xs font-bold bg-amber-100 text-amber-800 rounded-full"><i
                                                class="fa-solid fa-spinner animate-spin mr-1"></i> စိစစ်ဆဲ</span>
                                    @elseif($loan->status == 'accepted')
                                        <span class="px-3 py-1 text-xs font-bold bg-green-100 text-green-800 rounded-full"><i
                                                class="fa-solid fa-circle-check mr-1"></i> ခွင့်ပြုပြီး</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-bold bg-red-100 text-red-800 rounded-full"><i
                                                class="fa-solid fa-circle-xmark mr-1"></i> ပယ်ချထား</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button type="button"
                                        onclick="openLoanModal({{ json_encode($loan) }}, '{{ asset('storage') }}')"
                                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-1.5 px-3 rounded-lg text-xs shadow transition inline-flex items-center">
                                        <i class="fa-solid fa-eye mr-1"></i> View အပြည့်စုံပြပါ
                                    </button>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="loanModal"
        class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center p-4 backdrop-blur-sm transition-all">
        <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-100 transform scale-95 transition-transform duration-300"
            id="modalContent">
            <div class="bg-green-600 p-4 text-white flex justify-between items-center sticky top-0 rounded-t-2xl shadow">
                <h3 class="text-lg font-bold"><i class="fa-solid fa-circle-info mr-1"></i> ချေးငွေလျှောက်လွှာ အသေးစိတ်</h3>
                <button onclick="closeLoanModal()"
                    class="text-white hover:text-gray-200 text-xl font-bold p-1">&times;</button>
            </div>

            <div class="p-6 space-y-6">
                <div id="m_status_alert" class="p-3 rounded-xl text-sm font-bold flex items-center mb-2"></div>

                <div id="remainder_container"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 font-bold uppercase">စုငွေစာရင်းနံပါတ်</p>
                        <p id="m_borrower_id" class="text-gray-800 font-semibold mt-0.5">-</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 font-bold">အလုပ်အကိုင်</p>
                        <p id="m_occupation" class="text-gray-800 font-semibold mt-0.5">-</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 font-bold">လစဉ်ဝင်ငွေ</p>
                        <p id="m_monthly_income" class="text-gray-800 font-semibold mt-0.5">-</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 font-bold">ချေးငွေအမျိုးအစား</p>
                        <p id="m_loan_type" class="text-gray-800 font-semibold mt-0.5">-</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 font-bold">ရာသီဥတု</p>
                        <p id="m_season_type" class="text-gray-800 font-semibold mt-0.5">-</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 font-bold">ဧကပမာဏ</p>
                        <p id="m_acres" class="text-gray-800 font-semibold mt-0.5">-</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 font-bold">သတ်မှတ်အတိုးနှုန်း</p>
                        <p id="m_rate" class="text-gray-800 font-semibold mt-0.5">-</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 font-bold">စုစုပေါင်းချေးငွေပမာဏ</p>
                        <p id="m_total_amount" class="text-green-600 font-bold text-lg mt-0.5">-</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 font-bold">အတိုး/အရင်း ဆပ်ရမည့်ပုံစံ</p>
                        <p id="m_atone_none" class="text-gray-800 font-semibold mt-0.5">-</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 font-bold">အာမခံသူအမည်</p>
                        <p id="m_guarantor_name" class="text-gray-800 font-semibold mt-0.5">-</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 font-bold">Start Date</p>
                        <p id="m_start_date" class="text-gray-800 font-semibold mt-0.5">-</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 font-bold">End Date</p>
                        <p id="m_end_date" class="text-red-600 font-semibold mt-0.5">-</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 md:col-span-2">
                        <p class="text-xs text-gray-400 font-bold">အလုပ်နေရာ လိပ်စာ</p>
                        <p id="m_workplace_address" class="text-gray-800 mt-0.5 text-sm">-</p>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-gray-700 mb-3 border-l-4 border-green-600 pl-2">🖼️ တင်သွင်းထားသော
                        စာရွက်စာတမ်းများ</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="text-center">
                            <p class="text-[11px] text-gray-400 font-bold mb-1">ပုံစံခွန်</p><a id="link_tax" href="#"
                                target="_blank"><img id="img_tax" src=""
                                    class="w-full h-24 object-cover rounded-lg border hover:scale-105 transition shadow-sm"></a>
                        </div>
                        <div class="text-center">
                            <p class="text-[11px] text-gray-400 font-bold mb-1">အိမ်ထောင်စု</p><a id="link_household"
                                href="#" target="_blank"><img id="img_household" src=""
                                    class="w-full h-24 object-cover rounded-lg border hover:scale-105 transition shadow-sm"></a>
                        </div>
                        <div class="text-center">
                            <p class="text-[11px] text-gray-400 font-bold mb-1">မှတ်ပုံတင် (ရှေ့)</p><a id="link_nrc_front"
                                href="#" target="_blank"><img id="img_nrc_front" src=""
                                    class="w-full h-24 object-cover rounded-lg border hover:scale-105 transition shadow-sm"></a>
                        </div>
                        <div class="text-center">
                            <p class="text-[11px] text-gray-400 font-bold mb-1">မှတ်ပုံတင် (နောက်)</p><a id="link_nrc_back"
                                href="#" target="_blank"><img id="img_nrc_back" src=""
                                    class="w-full h-24 object-cover rounded-lg border hover:scale-105 transition shadow-sm"></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-4 flex justify-end border-t rounded-b-2xl">
                <button onclick="closeLoanModal()"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-5 rounded-xl text-sm transition shadow">ပိတ်မည်</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwind.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#loanTable').DataTable({ "order": [[0, "desc"]] });
        });

        function openLoanModal(loan, storageUrl) {
            document.getElementById('m_borrower_id').innerText = "000" + loan.borrower_id;
            document.getElementById('m_occupation').innerText = loan.occupation;
            document.getElementById('m_monthly_income').innerText = parseInt(loan.monthly_income).toLocaleString() + " ကျပ်";
            document.getElementById('m_loan_type').innerText = loan.loan_type;
            document.getElementById('m_season_type').innerText = (loan.season_type === 'rainy') ? "🌧️ မိုးသီးနှံ" : "❄️ ဆောင်းသီးနှံ";
            document.getElementById('m_acres').innerText = loan.acres + " ဧက";
            document.getElementById('m_rate').innerText = loan.rate + " %";
            document.getElementById('m_total_amount').innerText = parseInt(loan.total_amount).toLocaleString() + " ကျပ်";
            document.getElementById('m_atone_none').innerText = loan.atone_none;
            document.getElementById('m_guarantor_name').innerText = loan.guarantor_name;
            document.getElementById('m_start_date').innerText = loan.loan_start_date || 'မသတ်မှတ်ရသေးပါ';
            document.getElementById('m_end_date').innerText = loan.loan_end_date || 'မသတ်မှတ်ရသေးပါ';
            document.getElementById('m_workplace_address').innerText = loan.workplace_address;

            const alertBox = document.getElementById('m_status_alert');
            const remainderContainer = document.getElementById('remainder_container');
            remainderContainer.innerHTML = '';

            if (loan.status === 'accepted') {
                alertBox.className = "p-3 rounded-xl text-sm font-bold flex items-center mb-2 bg-green-50 text-green-800 border border-green-200";
                alertBox.innerHTML = "✅ ချေးငွေခွင့်ပြုချက် ရရှိပြီးပါပြီ (Approved)";
                alertBox.innerHTML = `
            <div class="flex justify-between items-center w-full">
                <span>✅ ချေးငွေခွင့်ပြုချက် ရရှိပြီးပါပြီ (Approved)</span>
                <a href="/loan/repay-detail/${loan.id}"
                   class="ml-4 bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs shadow transition">
                   ပေးချေရန်သွားမည် ➔
                </a>
            </div>
        `;

                // Remainder Section ကို ဤပုံစံအတိုင်း အစားထိုးလိုက်ပါ
                // openLoanModal function အတွင်းရှိ remainderContainer.innerHTML အပိုင်းကို ဤသို့ပြောင်းပါ
                if (loan.loan_remainder) {
                    const totalAmount = parseFloat(loan.loan_remainder.total_repayment_amount || 0).toLocaleString('en-US');

                    remainderContainer.innerHTML = `
            <div class="bg-white border-t-4 border-green-700 rounded-lg shadow-xl p-6 mb-6 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 opacity-5">
                    <i class="fa-solid fa-file-invoice-dollar text-[120px]"></i>
                </div>

                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-green-900 font-bold text-lg uppercase tracking-wider">ချေးငွေ ပြန်ဆပ်ရန် စာရင်း</h3>
                        <p class="text-xs text-gray-500 font-medium">LOAN REPAYMENT SCHEDULE</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase font-bold mb-1">စုစုပေါင်းဆပ်ရန်ပမာဏ</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-black text-gray-900">${totalAmount}</span>
                            <span class="text-sm font-bold text-gray-500">ကျပ်</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase font-bold mb-1">နောက်ဆုံးထားပေးချေရမည့်ရက်</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-xl font-bold text-green-700">${loan.loan_remainder.repayment_date}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-dashed border-gray-200">
                    <p class="text-[10px] text-gray-400 italic">
                        * သတ်မှတ်ရက်အတွင်း အပြည့်အဝပေးချေရန်နှင့် နောက်ကျပါက ငွေပေးချေမှုပုံစံအတိုင်း အတိုးနှုန်း သက်ရောက်နိုင်ပါသည်။
                    </p>
                </div>
            </div>`;
                }
            } else if (loan.status === 'pending') {
                alertBox.className = "p-3 rounded-xl text-sm font-bold flex items-center mb-2 bg-amber-50 text-amber-800 border border-amber-200";
                alertBox.innerHTML = "⚠️ ဘဏ်မှ စိစစ်နေဆဲဖြစ်ပါသည် (Pending)";
            } else {
                alertBox.className = "p-3 rounded-xl text-sm font-bold flex items-center mb-2 bg-red-50 text-red-800 border border-red-200";
                alertBox.innerHTML = "❌ ချေးငွေ လျှောက်ထားမှုကို ပယ်ချထားပါသည် (Rejected)";
            }

            document.getElementById('img_tax').src = storageUrl + '/' + loan.tax_form_image;
            document.getElementById('link_tax').href = storageUrl + '/' + loan.tax_form_image;
            document.getElementById('img_household').src = storageUrl + '/' + loan.household_chart_image;
            document.getElementById('link_household').href = storageUrl + '/' + loan.household_chart_image;
            document.getElementById('img_nrc_front').src = storageUrl + '/' + loan.nrc_front_image;
            document.getElementById('link_nrc_front').href = storageUrl + '/' + loan.nrc_front_image;
            document.getElementById('img_nrc_back').src = storageUrl + '/' + loan.nrc_back_image;
            document.getElementById('link_nrc_back').href = storageUrl + '/' + loan.nrc_back_image;

            document.getElementById('loanModal').classList.remove('hidden');
        }

        function closeLoanModal() {
            document.getElementById('loanModal').classList.add('hidden');
        }
    </script>
@endsection
