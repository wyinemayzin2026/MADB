<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; background-color: #f8fafc; color: #334155; padding: 20px; }
        .card { background: #ffffff; padding: 24px; border-radius: 12px; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-weight: bold; font-size: 12px; }
        .resolved { background-color: #dcfce7; color: #15803d; }
        .rejected { background-color: #fee2e2; color: #b91c1c; }
        .pending { background-color: #fef3c7; color: #b45309; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="color: #0f172a; border-bottom: 2px solid #10b981; padding-bottom: 10px;">
            📩 သင့်တိုင်ကြားစာနှင့် ပတ်သက်၍ အကြောင်းပြန်ကြားချက်
        </h2>

        <p>မင်္ဂလာပါရှင်/ခင်ဗျာ၊</p>
        <p>သင် ပေးပို့ထားသော တိုင်ကြားစာ <strong>"{{ $complaint->subject }}"</strong> နှင့် ပတ်သက်၍ တာဝန်ရှိသူများမှ စိစစ်ပြီး အောက်ပါအတိုင်း အကြောင်းပြန်ကြားအပ်ပါသည်။</p>

        <div style="margin: 16px 0;">
            <strong>လက်ရှိ အခြေအနေ:</strong>
            @if($status == 'resolved')
                <span class="status-badge resolved">✓ ဖြေရှင်းပြီး (Resolved)</span>
            @elseif($status == 'rejected')
                <span class="status-badge rejected">✕ ငြင်းပယ်ခဲ့သည် (Rejected)</span>
            @else
                <span class="status-badge pending">⏳ စိစစ်ဆဲ (Pending)</span>
            @endif
        </div>

        @if($replyNote)
            <div style="background: #f1f5f9; padding: 15px; border-radius: 8px; font-size: 14px; margin-top: 15px;">
                <strong>အကြောင်းပြန်ကြားချက် အချက်အလက်:</strong>
                <p style="margin-top: 5px; white-space: pre-line;">{{ $replyNote }}</p>
            </div>
        @endif

        <p style="margin-top: 25px; font-size: 12px; color: #64748b;">
            ကျေးဇူးတင်ပါသည်၊<br>
            Customer Support Team
        </p>
    </div>
</body>
</html>
