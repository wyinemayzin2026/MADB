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
            <div class="card-header">
                <h3>တောင်သူချေးငွေ ပြန်ဆပ်ပြီးစာရင်း</h3>
            </div>
            <div class="card-body">
                <table id="loanTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>တောင်သူအမည်</th>
                            <th>မူရင်းချေးငွေ</th>
                            <th>ပြန်ဆပ်ငွေ</th>

                            <th>ရက်စွဲ</th>
                            <th class="text-center">လုပ်ဆောင်ချက်</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($repayments as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->borrowerLoan->borrower->full_name ?? 'N/A' }}</td>
                                <td>{{ number_format($item->borrowerLoan->total_amount ?? 0, 0) }} MMK</td>
                                <td>{{ number_format($item->total_repayment_amount ?? 0, 0) }} MMK</td>

                                <td>{{ \Carbon\Carbon::parse($item->repayment_date)->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-info text-white"
                                        onclick="viewRemainder({{ json_encode($item->load('borrowerLoan.borrower')) }})">
                                        <i class="fas fa-eye"></i> ကြည့်ရန်
                                    </button>

                                    @if($item->status == 'repaid')
    <form action="{{ route('loans.updateStatus', $item->id) }}" method="POST" class="d-inline">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="accepted">
        <button type="submit" class="btn btn-sm btn-success">
            <i class="fas fa-check"></i> စစ်ဆေးပြီး မှန်ကန်သည်
        </button>
    </form>

    <form action="{{ route('loans.updateStatus', $item->id) }}" method="POST" class="d-inline">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="rejected">
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="fas fa-times"></i> ငြင်းပယ်
        </button>
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

    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">အသေးစိတ် အချက်အလက်</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailsBody"></div>
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

        function viewRemainder(item) {
            let loan = item.borrower_loan;
            let borrower = loan.borrower;
            let statusMyanmar = '';
            let badgeClass = '';

            if (item.status === 'repaid') {
                statusMyanmar = 'တောင်သူမှ ငွေပြန်လည်ဆပ်ထားသည်';
                badgeClass = 'bg-success';
            } else if (item.status === 'accepted') {
                statusMyanmar = 'တောင်သူ၏ ငွေပြန်လည်ဆပ်မှု အောင်မြင်သည်';
                badgeClass = 'bg-primary';
            } else if (item.status === 'rejected') {
                statusMyanmar = 'တောင်သူ၏ အား ငွေပြန်လည်ဆပ်မှု  အမှားယွင်းရှိသဖြင့် ပယ်ချထားသည်';
                badgeClass = 'bg-danger';
            } else {
                statusMyanmar = item.status;
                badgeClass = 'bg-secondary';
            }

            let html = `
                <ul class="list-group list-group-flush">
                     <li class="list-group-item d-flex justify-content-between">
            <span>အခြေအနေ:</span>
            <span class="badge ${badgeClass}">${statusMyanmar}</span>
        </li>
                    <li class="list-group-item d-flex justify-content-between"><span>တောင်သူအမည်:</span> <strong>${borrower?.full_name || 'N/A'}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>ဖုန်းနံပါတ်:</span> <strong>${borrower?.phone_number || '-'}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>အလုပ်အကိုင်:</span> <strong>${loan.occupation || '-'}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>လစဉ်ဝင်ငွေ:</span> <strong>${parseFloat(loan.monthly_income || 0).toLocaleString()} MMK</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>လုပ်ငန်းလိပ်စာ:</span> <strong>${loan.workplace_address || '-'}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>စုငွေစာရင်းနံပါတ်:</span> <strong>${loan.saving_account_number || '-'}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>ဧက:</span> <strong>${loan.acres || '-'}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>ရာသီ:</span> <strong>${loan.season_type === 'rainy' ? 'မိုးရာသီ' : 'ဆောင်းရာသီ'}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>ချေးငွေအမျိုးအစား:</span> <strong>${loan.loan_type || '-'}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>ချေးငွေကန့်သတ်ချက်:</span> <strong>${parseFloat(loan.loan_limit || 0).toLocaleString()}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>အတိုးနှုန်း:</span> <strong>${loan.rate || 0}%</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>မူရင်းချေးငွေ:</span> <strong>${parseFloat(loan.total_amount || 0).toLocaleString()} MMK</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>ကာလ:</span> <strong>${loan.loan_start_date} - ${loan.loan_end_date}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>အာမခံသူ:</span> <strong>${loan.guarantor_name || '-'}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>ပြန်ဆပ်ရမည့်ပမာဏ:</span> <strong>${parseFloat(item.total_repayment_amount || 0).toLocaleString()} MMK</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>ပြန်ဆပ်ရမည့်ရက်:</span> <strong>${item.repayment_date || '-'}</strong></li>

                </ul>
            `;
            $('#detailsBody').html(html);
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        }
    </script>
@endsection
