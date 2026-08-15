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

        .payment-img-preview {
            max-height: 250px;
            object-fit: contain;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            cursor: pointer;
        }
    </style>

    <div class="container-fluid p-4">
        <div class="card shadow">
            <div class="card-header">
                <h3 class="m-0 text-white font-bold">တောင်သူချေးငွေ ပြန်ဆပ်ပြီးစာရင်း</h3>
            </div>
            <div class="card-body">
                <table id="loanTable" class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>တောင်သူအမည်</th>
                            <th>ပေးချေမှုအမျိုးအစား</th>
                            <th>မူရင်းချေးငွေ</th>
                            <th>ပြန်ဆပ်ငွေ</th>
                            <th>ရက်လွန်ဒဏ်ကြေး</th>
                            <th>ရက်စွဲ</th>
                            <th>လက်ရှိ အခြေအနေ</th>
                            <th class="text-center">လုပ်ဆောင်ချက်</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($repayments as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->borrowerLoan->borrower->full_name ?? 'N/A' }}</td>
                                <td>
                                    @if(($item->borrowerLoan->repayment_type ?? 'online') === 'online')
                                        <span class="badge bg-primary">အွန်လိုင်းမှ ပြန်ဆပ်မည်</span>
                                    @else
                                        <span class="badge bg-secondary"> အပြင်တွင်လာရောက်ဆပ်သည် </span>
                                    @endif
                                </td>
                                <td>{{ number_format($item->borrowerLoan->total_amount ?? 0, 0) }} ကျပ်</td>
                                <td>{{ number_format($item->net_total_repayment_amount ?? 0, 0) }} ကျပ်</td>
                                <td>
                                    @if($item->is_overdue)
                                        <span class="badge bg-danger">ပေးဆောင်ရန်လိုသည်</span>
                                    @else
                                        <span class="badge bg-success">မလိုအပ်ပါ</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->repayment_date)->format('d-m-Y') }}</td>
                                <td class="p-4 text-center">
                                    @if($item->status == 'accepted')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 font-bold rounded-full text-[11px]">
                                            ✓ အတည်ပြုလက်ခံခဲ့သည်
                                        </span>
                                    @elseif($item->status == 'rejected')
                                        <span class="px-3 py-1 bg-red-100 text-red-700 font-bold rounded-full text-[11px]">
                                            ✕ ငြင်းပယ်ခဲ့သည်
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 font-bold rounded-full text-[11px]">
                                            ⏳ စိစစ်ဆဲ
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-info text-white me-1"
                                        onclick="viewRemainder({{ json_encode($item->load(['borrowerLoan.borrower', 'borrowerLoan.payments'])) }})">
                                        <i class="fas fa-eye"></i> ကြည့်ရန်
                                    </button>

                                    @if($item->status == "rejected")
                                        <form action="{{ route('loans.updateStatus', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="btn btn-sm btn-success me-1">
                                                <i class="fas fa-check"></i> ပြန်လည်အတည်ပြုမည်
                                            </button>
                                        </form>
                                    @endif
                                    @if($item->status == 'repaid')
                                        <form action="{{ route('loans.updateStatus', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="btn btn-sm btn-success me-1">
                                                <i class="fas fa-check"></i> အတည်ပြုမည်
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

    <!-- Modal (အသေးစိတ်ကြည့်ရန်) -->
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

    <!-- Modal (Screenshot ဓာတ်ပုံ အကြီးကြည့်ရန်) -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ငွေလွှဲပြေစာ ဓာတ်ပုံ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded" alt="Payment Screenshot">
                </div>
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

        function showFullImage(src) {
            $('#modalImage').attr('src', src);
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }

        function viewRemainder(item) {
            let loan = item.borrower_loan;
            let borrower = loan ? loan.borrower : null;
            let payments = (loan && loan.payments && loan.payments.length > 0) ? loan.payments : [];
            let payment = payments.length > 0 ? payments[payments.length - 1] : null; // နောက်ဆုံး Payment record ကို ယူမည်

            let statusMyanmar = '';
            let badgeClass = '';
            let penaltyText = item.is_overdue ? 'ပေးဆောင်ရန်လိုသည်' : 'မလိုအပ်ပါ';
            let isOverdue = item.is_overdue;
            let penaltyAmount = isOverdue ? (parseFloat(item.total_repayment_amount) * 0.05) : 0;

            if (item.status === 'repaid') {
                statusMyanmar = 'တောင်သူမှ ငွေပြန်လည်ဆပ်ထားသည် (စစ်ဆေးရန်)';
                badgeClass = 'bg-warning text-dark';
            } else if (item.status === 'accepted') {
                statusMyanmar = 'တောင်သူ၏ ငွေပြန်လည်ဆပ်မှု အောင်မြင်သည်';
                badgeClass = 'bg-success';
            } else if (item.status === 'rejected') {
                statusMyanmar = 'ငွေပြန်လည်ဆပ်မှု အမှားယွင်းရှိသဖြင့် ပယ်ချထားသည်';
                badgeClass = 'bg-danger';
            } else {
                statusMyanmar = item.status;
                badgeClass = 'bg-secondary';
            }

            // ၁။ တောင်သူနှင့် ချေးငွေ အသေးစိတ် အချက်အလက်များ
            let html = `
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded border">
                                        <span class="fw-bold">အခြေအနေ:</span>
                                        <span class="badge ${badgeClass} fs-6">${statusMyanmar}</span>
                                    </div>
                                </div>
                        `;

            // ၂။ တကယ်လို့ Online Payment ဖြစ်ပြီး Payments Table ထဲတွင် Data ရှိပါက Payment Info Card ပြသမည်
            if (loan.repayment_type === 'online' && payment) {
                let screenshotUrl = payment.payment_screenshot ? `/storage/${payment.payment_screenshot}` : null;

                html += `
                                <div class="col-12 mt-3">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white py-2">
                                            <h6 class="m-0 fw-bold"><i class="fas fa-credit-card me-2"></i> Online ငွေပေးချေမှု အချက်အလက်များ</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>ငွေပေးချေသည့် နည်းလမ်း:</span>
                @if(($item->borrowerLoan->repayment_type ?? 'online') === 'online')
                    <span class="badge bg-primary">အွန်လိုင်းမှ ပြန်ဆပ်ထားသည်</span>
                @else
                    <span class="badge bg-secondary">အပြင်တွင် လာရောက်ဆပ်သည်</span>
                @endif
            </li>
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            <span>လုပ်ငန်းစဉ်အမှတ်:</span>
                                                            <strong class="text-danger">${payment.transaction_id || '-'}</strong>
                                                        </li>
                                                        ${payment.payment_method === 'BankTransfer' ? `
                                                            <li class="list-group-item d-flex justify-content-between"><span>ဘဏ်အမည်:</span> <strong>${payment.bank_name || '-'}</strong></li>
                                                            <li class="list-group-item d-flex justify-content-between"><span>အကောင့်အမှတ်:</span> <strong>${payment.account_number || '-'}</strong></li>
                                                            <li class="list-group-item d-flex justify-content-between"><span>အကောင့်ပိုင်ရှင်အမည်:</span> <strong>${payment.account_holder_name || '-'}</strong></li>
                                                        ` : ''}

                                                    </ul>
                                                </div>
                                                <div class="col-md-5 text-center mt-3 mt-md-0">
                                                    <span class="d-block mb-2 text-muted fw-bold">ငွေလွှဲပြေစာ ဓာတ်ပုံ</span>
                                                    ${screenshotUrl ? `
                                                        <img src="${screenshotUrl}" class="payment-img-preview shadow-sm" onclick="showFullImage('${screenshotUrl}')" title="နှိပ်၍ အကြီးကြည့်ပါ">
                                                        <small class="d-block text-muted mt-1">(ပုံကို နှိပ်၍ အကြီးကြည့်နိုင်သည်)</small>
                                                    ` : '<span class="text-danger">ဓာတ်ပုံ တင်ထားခြင်းမရှိပါ</span>'}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
            } else if (loan.repayment_type === 'outside') {
                html += `
                                <div class="col-12 mt-2">
                                    <div class="alert alert-info m-0">
                                        <strong>📌 ပေးချေမှုအမျိုးအစား:</strong> အပြင်တွင် Direct တိုက်ရိုက်ပေးချေမှုဖြစ်သဖြင့် Online ငွေလွှဲပြေစာ မရှိပါ။
                                    </div>
                                </div>
                            `;
            }

            // ၃။ ချေးငွေ အသေးစိတ် အချက်အလက်များ
            html += `
                            <div class="col-12 mt-3">
                                <h6 class="fw-bold text-secondary border-bottom pb-2">ချေးငွေဆိုင်ရာ အချက်အလက်များ</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between"><span>တောင်သူအမည်:</span> <strong>${borrower?.full_name || 'N/A'}</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>ဖုန်းနံပါတ်:</span> <strong>${borrower?.phone_number || '-'}</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>အလုပ်အကိုင်:</span> <strong>${loan.occupation || '-'}</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>လစဉ်ဝင်ငွေ:</span> <strong>${parseFloat(loan.monthly_income || 0).toLocaleString()} ကျပ်</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>လုပ်ငန်းလိပ်စာ:</span> <strong>${loan.workplace_address || '-'}</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>စုငွေစာရင်းနံပါတ်:</span> <strong>${loan.saving_account_number || '-'}</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>ဧက:</span> <strong>${loan.acres || '-'}</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>ရာသီ:</span> <strong>${loan.season_type === 'rainy' ? 'မိုးရာသီ' : 'ဆောင်းရာသီ'}</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>ချေးငွေအမျိုးအစား:</span> <strong>${loan.loan_type || '-'}</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>ချေးငွေကန့်သတ်ချက်:</span> <strong>${parseFloat(loan.loan_limit || 0).toLocaleString()} ကျပ်</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>အတိုးနှုန်း:</span> <strong>${loan.rate || 0}%</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>မူရင်းချေးငွေ:</span> <strong>${parseFloat(loan.total_amount || 0).toLocaleString()} ကျပ်</strong></li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>ရက်လွန်ဒဏ်ကြေး:</span>
                                        <strong class="${isOverdue ? 'text-danger' : 'text-success'}">
                                            ${penaltyText} (${penaltyAmount.toLocaleString()} ကျပ်)
                                        </strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between"><span>အတိုးနှင့်အရင်း စုစုပေါင်း:</span> <strong>${parseFloat(item.total_repayment_amount || 0).toLocaleString()} ကျပ်</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>ပြန်ဆပ်ရမည့်ပမာဏ:</span> <strong class="text-success fs-5">${parseFloat(item.net_total_repayment_amount || 0).toLocaleString()} ကျပ်</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>ပြန်ဆပ်ရမည့်ရက်:</span> <strong>${item.repayment_date || '-'}</strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>အာမခံသူ:</span> <strong>${loan.guarantor_name || '-'}</strong></li>
                                </ul>
                            </div>
                        </div>`;

            $('#detailsBody').html(html);
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        }
    </script>
@endsection
