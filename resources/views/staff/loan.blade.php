@extends('layouts.staff_app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary-green: #198754; }
        .card { border-radius: 12px; border: none; }
        .card-header { background-color: var(--primary-green) !important; color: white; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem; }
        .table thead { background-color: #f8f9fa; }
        .btn-success { background-color: var(--primary-green); border-color: var(--primary-green); }
        .btn-info { background-color: #0dcaf0; color: white; border: none; }
        .badge { font-weight: 500; }
        .modal-header { background-color: #f8f9fa; border-bottom: 2px solid var(--primary-green); }
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
                            <th>ချေးငှားသူအမည်</th>
                            <th>ချေးငွေပမာဏ</th>
                            <th>ချေးငွေ အမျိုးအစား</th>
                            <th>Status</th>
                            <th>လုပ်ဆောင်ချက်များ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr>
                                <td>{{ $loan->borrower->full_name ?? 'N/A' }}</td>
                                <td>{{ number_format($loan->total_amount, 2) }}</td>
                                <td>
                                    @if($loan->season_type == 'rainy')
                                        မိုးရာသီချေးငွေ
                                    @elseif($loan->season_type == 'winter')
                                        ဆောင်းရာသီချေးငွေ
                                    @else
                                        {{ ucfirst($loan->season_type) }}
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge {{ $loan->status == 'pending' ? 'bg-warning' : ($loan->status == 'accepted' ? 'bg-success' : 'bg-danger') }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info"
                                        onclick="viewLoan({{ json_encode($loan->load('borrower')) }})">View</button>

                                    @if($loan->status == 'pending')
                                        <form action="{{ route('loans.updateStatus', $loan->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="btn btn-sm btn-success">Accept</button>
                                        </form>
                                        <form action="{{ route('loans.updateStatus', $loan->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
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

    <div class="modal fade" id="viewLoanModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Loan Details</h5>
                </div>
                <div class="modal-body" id="loanDetailsBody"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#loanTable').DataTable();
        });

        function viewLoan(loan) {
    // Season မြန်မာဘာသာသို့ပြောင်းခြင်း
    let seasonMyanmar = (loan.season_type === 'rainy') ? 'မိုးရာသီ' : 'ဆောင်းရာသီ';

    let html = `
        <div class="row">
            <div class="col-md-6">
                <p><b>ချေးငွေယူသူ:</b> ${loan.borrower ? loan.borrower.full_name : 'N/A'}</p>
                <p><b>အလုပ်အကိုင်:</b> ${loan.occupation}</p>
                <p><b>လစဉ်ဝင်ငွေ:</b> ${parseFloat(loan.monthly_income).toLocaleString()} ကျပ်</p>
                <p><b>လုပ်ငန်းလိပ်စာ:</b> ${loan.workplace_address}</p>
                <p><b>စုငွေစာရင်းနံပါတ်:</b> ${loan.saving_account_number}</p>
                <p><b>ဧက:</b> ${loan.acres}</p>
                <p><b>ရာသီ:</b> ${seasonMyanmar}</p>
                <p><b>ချေးငွေအမျိုးအစား:</b> ${loan.loan_type}</p>
                <p><b>ချေးငွေကန့်သတ်ချက်:</b> ${loan.loan_limit}</p>
                <p><b>အတိုးနှုန်း:</b> ${loan.rate}%</p>
                <p><b>စုစုပေါင်းငွေ:</b> ${parseFloat(loan.total_amount).toLocaleString()} ကျပ်</p>
                <p><b>ကာလ:</b> ${loan.loan_start_date} မှ ${loan.loan_end_date} ထိ</p>
                <p><b>အာမခံသူ:</b> ${loan.guarantor_name}</p>
            </div>
            <div class="col-md-6">
                <h6>တင်သွင်းထားသော စာရွက်စာတမ်းများ:</h6>
                <p><b>ပုံစံခွန်:</b> <br><img src="/storage/${loan.tax_form_image}" width="100" class="img-thumbnail"></p>
                <p><b>အိမ်ထောင်စုဇယား:</b> <br><img src="/storage/${loan.household_chart_image}" width="100" class="img-thumbnail"></p>
                <p><b>မှတ်ပုံတင် (အရှေ့):</b> <br><img src="/storage/${loan.nrc_front_image}" width="100" class="img-thumbnail"></p>
                <p><b>မှတ်ပုံတင် (အနောက်):</b> <br><img src="/storage/${loan.nrc_back_image}" width="100" class="img-thumbnail"></p>
            </div>
        </div>
    `;

    $('#loanDetailsBody').html(html);
    $('#viewLoanModal .modal-dialog').addClass('modal-lg'); // Modal ကို အနည်းငယ်ပိုကျယ်အောင်လုပ်ခြင်း
    new bootstrap.Modal($('#viewLoanModal')[0]).show();
}
    </script>
@endsection
