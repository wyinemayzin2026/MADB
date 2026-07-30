@extends('layouts.staff_app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #198754;
        }

        .card {
            border-radius: 12px;
            border: none;
        }

        .card-header {
            background-color: var(--primary-green) !important;
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.5rem;
        }

        .table thead {
            background-color: #f8f9fa;
        }

        .btn-success {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-info {
            background-color: #0dcaf0;
            color: white;
            border: none;
        }

        .badge {
            font-weight: 500;
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid var(--primary-green);
        }
    </style>

    <div class="container-fluid p-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ✓ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ⚠️ {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h3>ချေးငွေလျောက်လွာများ</h3>
        <div class="card shadow">
            <div class="card-body">
                <table id="loanTable" class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ချေးငှားသူ</th>
                            <th>ပမာဏ</th>
                            <th>ရာသီ</th>
                            <th>အခြေ အနေ</th>
                            <th class="text-center">လုပ်ဆောင်ချက်</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr>
                                <td class="fw-semibold">{{ $loan->borrower->full_name ?? 'N/A' }}</td>
                                <td>{{ number_format($loan->total_amount, 0) }} MMK</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $loan->season_type == 'rainy' ? 'မိုးရာသီ' : ($loan->season_type == 'winter' ? 'ဆောင်းရာသီ' : ucfirst($loan->season_type)) }}
                                    </span>
                                </td>
                                <td>
                                    @if($loan->is_closed)
                                        <span class="badge rounded-pill bg-secondary">အပြီးတိုင်ပိတ်ပြီး</span>
                                    @elseif($loan->status == 'pending')
                                        <span class="badge rounded-pill bg-warning text-dark">စောင့်ဆိုင်းဆဲ</span>
                                    @elseif($loan->status == 'accepted')
                                        <span class="badge rounded-pill bg-success">လက်ခံပြီး</span>
                                    @elseif($loan->status == 'resubmitted')
                                        <span class="badge rounded-pill bg-danger">ပြန်လည်ပြင်ဆင်ရန်</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger">ငြင်းပယ်ပြီး</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <div class="inline-flex items-center justify-center gap-1.5">

                                        <!-- ကြည့်ရန် (View Button) -->
                                        <button type="button"
                                            class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-white bg-sky-500 hover:bg-sky-600 rounded-lg shadow-sm transition-all duration-150 active:scale-95"
                                            onclick="viewLoan({{ json_encode($loan->load('borrower')) }})"
                                            title="အချက်အလက်များ ကြည့်ရန်">
                                            <i class="fa-solid fa-eye mr-1"></i> ကြည့်ရန်
                                        </button>

                                        @if(!$loan->is_closed)
                                            @if($loan->status == 'pending')
                                                <!-- လက်ခံမည် Form -->
                                                <form action="{{ route('staff.loans.updateStatus', $loan->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="accepted">
                                                    <button type="submit"
                                                        class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm transition-all duration-150 active:scale-95"
                                                        onclick="return confirm('ဤလျှောက်လွှာကို လက်ခံရန် သေချာပါသလား။')"
                                                        title="လက်ခံမည်">
                                                        <i class="fa-solid fa-check mr-1"></i> လက်ခံ
                                                    </button>
                                                </form>

                                                <!-- ပယ်ချမည် (Reject Modal Button) -->
                                                <button type="button"
                                                    class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-lg shadow-sm transition-all duration-150 active:scale-95"
                                                    onclick="openRejectModal({{ $loan->id }})" title="ပယ်ချမည်">
                                                    <i class="fa-solid fa-xmark mr-1"></i> ပယ်ချမည်
                                                </button>

                                                <!-- အပြီးတိုင်ပိတ်မည် (Close Loan Modal Button) -->
                                                <button type="button"
                                                    class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-gray-100 bg-slate-800 hover:bg-slate-900 rounded-lg shadow-sm transition-all duration-150 active:scale-95"
                                                    onclick="openCloseLoanModal({{ $loan->id }})" title="အပြီးတိုင်ပိတ်မည်">
                                                    <i class="fa-solid fa-lock mr-1"></i> အပြီးတိုင်ပိတ်မည်
                                                </button>
                                            @endif
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 1. View Detail Loan Modal -->
    <div class="modal fade" id="viewLoanModal" tabindex="-1" aria-labelledby="viewLoanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="viewLoanModalLabel">ချေးငွေအချက်အလက်အသေးစိတ်</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="loanDetailsBody"></div>
            </div>
        </div>
    </div>

    <!-- 2. Rejection Reason Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="rejectForm" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="resubmitted">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title fw-bold" id="rejectModalLabel">ငြင်းပယ်ရသည့် အကြောင်းအရင်း</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rejected_reason" class="form-label fw-bold">ပြင်ဆင်ရန် အကြောင်းအရင်း ရေးသားပါ
                                -</label>
                            <textarea name="rejected_reason" id="rejected_reason" rows="4" class="form-control" required
                                placeholder="ဥပမာ - မှတ်ပုံတင်ပုံ ရေရေရာရာ မမြင်ရပါသဖြင့် ပြန်လည်ပြင်ဆင်ပေးပါရန်..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">မလုပ်တော့ပါ</button>
                        <button type="submit" class="btn btn-danger">အကြောင်းပြချက် ပေးပို့မည်</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 3. Close Loan Confirmation Modal -->
    <div class="modal fade" id="closeLoanModal" tabindex="-1" aria-labelledby="closeLoanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="closeLoanForm" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="close_loan" value="1">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title fw-bold" id="closeLoanModalLabel">အတည်ပြုချက် တောင်းခံခြင်း</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <div class="mb-3">
                            <span class="fs-1 text-warning">⚠️</span>
                        </div>
                        <h6 class="fw-bold fs-5">ဤချေးငွေအား အပြီးတိုင် ပိတ်သိမ်းရန် သေချာပါသလား။</h6>
                        <p class="text-muted mb-0 mt-2">ပိတ်သိမ်းပြီးပါက ဤချေးငွေအား နောက်ထပ် ပြင်ဆင်မှုများ
                            ပြုလုပ်နိုင်တော့မည် မဟုတ်ပါ။</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">မလုပ်တော့ပါ</button>
                        <button type="submit" class="btn btn-dark">အတည်ပြုမည်</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#loanTable').DataTable();
        });

        // Rejection Modal ဖွင့်ပေးရန် Function
        function openRejectModal(loanId) {
            let url = "{{ route('staff.loans.updateStatus', ':id') }}";
            url = url.replace(':id', loanId);

            $('#rejectForm').attr('action', url);
            $('#rejected_reason').val('');
            var rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
            rejectModal.show();
        }

        // Close Loan Modal ဖွင့်ပေးရန် Function
        function openCloseLoanModal(loanId) {
            let url = "{{ route('staff.loans.updateStatus', ':id') }}";
            url = url.replace(':id', loanId);

            $('#closeLoanForm').attr('action', url);
            var closeLoanModal = new bootstrap.Modal(document.getElementById('closeLoanModal'));
            closeLoanModal.show();
        }

        // View Detail Function
        function viewLoan(loan) {
            let seasonMyanmar = (loan.season_type === 'rainy') ? 'မိုးရာသီ' : 'ဆောင်းရာသီ';

            let remainderRows = '';
            if (loan.status === 'accepted' && loan.loan_remainder) {
                remainderRows = `
                        <div class="card mt-3 border-danger shadow-sm">
                            <div class="card-header bg-danger text-white py-1">
                                <strong>⚠️ သတိပြုရန် - ပြန်ဆပ်ရမည့်အချက်အလက်</strong>
                            </div>
                            <div class="card-body py-2">
                                <p class="mb-1"><strong>စုစုပေါင်းပြန်ဆပ်ရန် (အတိုး ၅% အပါ):</strong>
                                    <span class="text-danger fw-bold">${parseFloat(loan.loan_remainder.total_repayment_amount || 0).toLocaleString()} ကျပ်</span>
                                </p>
                                <p class="mb-0"><strong>ပြန်ဆပ်ရမည့်ရက်:</strong>
                                    <span class="fw-bold">${new Date(loan.loan_remainder.repayment_date).toLocaleDateString('my-MM')}</span>
                                </p>
                            </div>
                        </div>`;
            }

            let rejectedReasonRow = '';
            if (loan.status === 'resubmitted' && loan.rejected_reason) {
                rejectedReasonRow = `
                        <div class="card mt-3 border-warning shadow-sm">
                            <div class="card-header bg-warning text-dark py-1">
                                <strong>⚠️ ပယ်ချခဲ့သည့် အကြောင်းအရင်း (Resubmit Reason)</strong>
                            </div>
                            <div class="card-body py-2">
                                <p class="mb-0 text-danger fw-bold">${loan.rejected_reason}</p>
                            </div>
                        </div>`;
            }

            let html = `
                <div class="row g-3">
                    <div class="col-md-7">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between"><span>ချေးငွေယူသူ:</span> <strong>${loan.borrower?.full_name || 'N/A'}</strong></li>
                            <li class="list-group-item d-flex justify-content-between"><span>အလုပ်အကိုင်:</span> <strong>${loan.occupation || '-'}</strong></li>
                            <li class="list-group-item d-flex justify-content-between"><span>လစဉ်ဝင်ငွေ:</span> <strong>${parseFloat(loan.monthly_income || 0).toLocaleString()} ကျပ်</strong></li>
                            <li class="list-group-item d-flex justify-content-between"><span>လုပ်ငန်းလိပ်စာ:</span> <strong>${loan.workplace_address || '-'}</strong></li>
                            <li class="list-group-item d-flex justify-content-between"><span>စုငွေစာရင်းနံပါတ်:</span> <strong>000${loan.saving_account_number || '-'}</strong></li>
                            <li class="list-group-item d-flex justify-content-between"><span>ဧက:</span> <strong>${loan.acres || '-'}</strong></li>
                            <li class="list-group-item d-flex justify-content-between"><span>ရာသီ:</span> <strong>${seasonMyanmar}</strong></li>
                            <li class="list-group-item d-flex justify-content-between"><span>ချေးငွေအမျိုးအစား:</span> <strong>${loan.loan_type || '-'}</strong></li>
                            <li class="list-group-item d-flex justify-content-between"><span>အတိုးနှုန်း:</span> <strong>${loan.rate || 0}%</strong></li>
                            <li class="list-group-item d-flex justify-content-between"><span>မူရင်းချေးငွေ:</span> <strong>${parseFloat(loan.total_amount || 0).toLocaleString()} ကျပ်</strong></li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>ကာလ:</span>
                                <strong>
                                    ${new Date(loan.loan_start_date).toLocaleDateString('en-US', { month: 'short', year: 'numeric' })} -
                                    ${new Date(loan.loan_end_date).toLocaleDateString('en-US', { month: 'short', year: 'numeric' })}
                                </strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between"><span>အာမခံသူ:</span> <strong>${loan.guarantor_name || '-'}</strong></li>
                        </ul>
                        ${remainderRows}
                        ${rejectedReasonRow}
                    </div>
                    <div class="col-md-5">
                        <h6 class="mb-3">တင်သွင်းထားသော စာရွက်စာတမ်းများ:</h6>

                        <div class="row mb-3">
                            <div class="col-6">
                                <p class="mb-1"><b>ပုံစံ(၇) :</b></p>
                                <a href="/storage/${loan.tax_form_image}" target="_blank">
                                    <img src="/storage/${loan.tax_form_image}" class="img-thumbnail w-100" style="max-height: 120px; object-fit: cover;">
                                </a>
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><b>အိမ်ထောင်စုဇယား:</b></p>
                                <a href="/storage/${loan.household_chart_image}" target="_blank">
                                    <img src="/storage/${loan.household_chart_image}" class="img-thumbnail w-100" style="max-height: 120px; object-fit: cover;">
                                </a>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <p class="mb-1"><b>မှတ်ပုံတင် (အရှေ့):</b></p>
                                <a href="/storage/${loan.nrc_front_image}" target="_blank">
                                    <img src="/storage/${loan.nrc_front_image}" class="img-thumbnail w-100" style="max-height: 120px; object-fit: cover;">
                                </a>
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><b>မှတ်ပုံတင် (အနောက်):</b></p>
                                <a href="/storage/${loan.nrc_back_image}" target="_blank">
                                    <img src="/storage/${loan.nrc_back_image}" class="img-thumbnail w-100" style="max-height: 120px; object-fit: cover;">
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="mb-1"><b>အာမခံသူ မှတ်ပုံတင် (အရှေ့):</b></p>
                                ${loan.guarantor_front_image
                    ? `<a href="/storage/${loan.guarantor_front_image}" target="_blank">
                                        <img src="/storage/${loan.guarantor_front_image}" class="img-thumbnail w-100" style="max-height: 120px; object-fit: cover;">
                                       </a>`
                    : `<span class="text-muted">မရှိပါ</span>`}
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><b>အာမခံသူ မှတ်ပုံတင် (အနောက်):</b></p>
                                ${loan.guarantor_nrc_back_image
                    ? `<a href="/storage/${loan.guarantor_nrc_back_image}" target="_blank">
                                        <img src="/storage/${loan.guarantor_nrc_back_image}" class="img-thumbnail w-100" style="max-height: 120px; object-fit: cover;">
                                       </a>`
                    : `<span class="text-muted">မရှိပါ</span>`}
                            </div>
                        </div>
                    </div>
                </div>`;

            $('#loanDetailsBody').html(html);
            var myModal = new bootstrap.Modal(document.getElementById('viewLoanModal'));
            myModal.show();
        }
    </script>
@endsection
