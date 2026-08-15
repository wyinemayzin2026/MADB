<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $complaint->subject }}</title>
    <style>
        body { font-family: sans-serif; background-color: #f8fafc; color: #334155; padding: 20px; }
        .card { background: #ffffff; padding: 24px; border-radius: 12px; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; }
        .header { border-bottom: 2px solid #10b981; padding-bottom: 12px; margin-bottom: 16px; }
        .info { background: #f1f5f9; padding: 12px; border-radius: 8px; font-size: 14px; margin-bottom: 16px; }
        .body-text { white-space: pre-line; line-height: 1.6; font-size: 15px; }
        .footer { font-size: 12px; color: #94a3b8; margin-top: 24px; text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h2 style="margin:0; color: #0f172a;">📩 တိုင်ကြားစာ အသစ် ရရှိပါသည်</h2>
        </div>

        <div class="info">
            <p style="margin: 4px 0;"><strong>From:</strong> {{ $complaint->from_email }}</p>
            <p style="margin: 4px 0;"><strong>To:</strong> {{ $complaint->to_email }}</p>
            <p style="margin: 4px 0;"><strong>Borrower ID:</strong> {{ $complaint->borrower_id ?? 'N/A' }}</p>
            <p style="margin: 4px 0;"><strong>Subject:</strong> {{ $complaint->subject }}</p>
        </div>

        <h3>အကြောင်းအရာ -</h3>
        <div class="body-text">
            {{ $complaint->body }}
        </div>

        @if(!empty($complaint->images))
            <p style="margin-top: 16px; font-size: 13px; color: #059669;">
                📎 <em>သက်သေခံ ဓါတ်ပုံများကို ဖိုင်တွဲ (Attachment) အဖြစ် ထည့်သွင်းပေးပို့ထားပါသည်။</em>
            </p>
        @endif
    </div>
</body>
</html>
