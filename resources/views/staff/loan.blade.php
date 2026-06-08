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
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3>Loan Applications</h3>
            </div>
            <div class="card-body">
                <table id="loanTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ချေးငှားသူ</th>
                            <th>ပမာဏ</th>
                            <th>ရာသီ</th>
                            <th>Status</th>
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
                                    <span
                                        class="badge rounded-pill {{ $loan->status == 'pending' ? 'bg-warning text-dark' : ($loan->status == 'accepted' ? 'bg-success' : 'bg-danger') }}">
                                        {{ $loan->status == 'pending' ? 'စောင့်ဆိုင်းဆဲ' : ($loan->status == 'accepted' ? 'လက်ခံပြီး' : 'ငြင်းပယ်ပြီး') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-info btn-action text-white"
                                        onclick="viewLoan({{ json_encode($loan->load('borrower')) }})">
                                        ကြည့်ရန်
                                    </button>
                                    @if($loan->status == 'pending')
                                        <form action="{{ route('loans.updateStatus', $loan->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="btn btn-sm btn-success btn-action">လက်ခံ</button>
                                        </form>
                                        <form action="{{ route('loans.updateStatus', $loan->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-danger btn-action">ပယ်ချမည်</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

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

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
    $('#loanTable').DataTable();
});

function viewLoan(loan) {
    let seasonMyanmar = (loan.season_type === 'rainy') ? 'မိုးရာသီ' : 'ဆောင်းရာသီ';

    // 1. Prepare Remainder HTML
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
        </div>
        <div class="col-md-5">
            <h6 class="mb-3">တင်သွင်းထားသော စာရွက်စာတမ်းများ:</h6>
            <p><b>ပုံစံခွန်:</b><br><a href="/storage/${loan.tax_form_image}" target="_blank"><img src="/storage/${loan.tax_form_image}" width="200" class="img-thumbnail mt-1"></a></p>
            <p><b>အိမ်ထောင်စုဇယား:</b><br><a href="/storage/${loan.household_chart_image}" target="_blank"><img src="/storage/${loan.household_chart_image}" width="200" class="img-thumbnail mt-1"></a></p>
            <p><b>မှတ်ပုံတင် (အရှေ့):</b><br><a href="/storage/${loan.nrc_front_image}" target="_blank"><img src="/storage/${loan.nrc_front_image}" width="200" class="img-thumbnail mt-1"></a></p>
            <p><b>မှတ်ပုံတင် (အနောက်):</b><br><a href="/storage/${loan.nrc_back_image}" target="_blank"><img src="/storage/${loan.nrc_back_image}" width="200" class="img-thumbnail mt-1"></a></p>
        </div>
    </div>`;

    // 3. Inject and Show
    $('#loanDetailsBody').html(html);
    var myModal = new bootstrap.Modal(document.getElementById('viewLoanModal'));
    myModal.show();
}
    </script>
@endsection
