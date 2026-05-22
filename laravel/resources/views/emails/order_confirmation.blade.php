<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>GoPrint - 訂單確認信</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f59e0b; color: white; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background-color: #f8f9fa; padding: 20px; }
        .order-details { background-color: white; padding: 15px; border-radius: 8px; margin-top: 15px; }
        .footer { margin-top: 20px; text-align: center; color: #6c757d; font-size: 12px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #f59e0b; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📦 GoPrint 打印服務</h1>
        <p>感謝您的訂購！</p>
    </div>

    <div class="content">
        <p>親愛的客戶，</p>
        <p>感謝您選擇 GoPrint！您的訂單已成功提交，我們會盡快處理您的印刷需求。</p>

        <div class="order-details">
            <h3>📋 訂單詳情</h3>
            <p><strong>訂單編號：</strong>#{{ $order->id }}</p>
            <p><strong>訂購日期：</strong>{{ $order->created_at->format('Y-m-d H:i:s') }}</p>
            <p><strong>訂單狀態：</strong>
                @if($order->status === 'pending') 待付款
                @elseif($order->status === 'processing') 處理中
                @elseif($order->status === 'awaiting_transfer') 待核實轉帳
                @elseif($order->status === 'completed') 已完成
                @else {{ $order->status }}
                @endif
            </p>
            <p><strong>聯絡人：</strong>{{ $order->name }}</p>
            <p><strong>聯絡電話：</strong>{{ $order->phone }}</p>
            <p><strong>電子郵件：</strong>{{ $order->email }}</p>
            <p><strong>總金額：</strong>HK${{ number_format($order->price, 2) }}</p>
        </div>

        @if($order->payment_method === 'bank_transfer')
        <div class="order-details" style="border-left: 4px solid #f59e0b;">
            <h3>🏦 銀行轉帳資料</h3>
            <p>請將款項轉入以下帳戶，並截圖 WHATSAPP 俾我哋確認：</p>
            <p><strong>收款人：</strong>Offset Printing Limited<br>
            <strong>FPS ID：</strong>1157 028 96<br>
            <strong>收款銀行：</strong>交通銀行</p>
        </div>
        @endif

        <p>如有任何問題，歡迎隨時聯絡我們：</p>
        <p>📧 客服電郵：support@goprint.com</p>
        <p>📞 客服熱線：+852 2565 7997</p>
        <p>💬 WhatsApp：+852 6098 7508</p>

        <p>再次感謝您的訂購！</p>
        <p>GoPrint 團隊敬上</p>
    </div>

    <div class="footer">
        <p>© 2026 GoPrint Hong Kong. All rights reserved.</p>
        <p>此郵件已發送至 {{ $order->email }}</p>
    </div>
</body>
</html>
