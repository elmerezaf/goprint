<!DOCTYPE html>
<html>
<head>
    <title>GoPrint - 訂單確認信</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #0d6efd; color: white; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background-color: #f8f9fa; padding: 20px; }
        .order-details { background-color: white; padding: 15px; border-radius: 8px; margin-top: 15px; }
        .footer { margin-top: 20px; text-align: center; color: #6c757d; font-size: 12px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #0d6efd; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📦 GoPrint 打印服務</h1>
        <p>感謝您的訂購！</p>
    </div>
    
    <div class="content">
        <p>親愛的客戶，</p>
        <p>感謝您選擇 GoPrint！您的訂單已成功提交，我們會盡快處理您的列印需求。</p>
        
        <div class="order-details">
            <h3>📋 訂單詳情</h3>
            <p><strong>訂單編號：</strong>{{ $order->order_no }}</p>
            <p><strong>訂購日期：</strong>{{ $order->created_at->format('Y-m-d H:i:s') }}</p>
            <p><strong>訂單狀態：</strong>{{ $order->status === 'pending' ? '待處理' : ($order->status === 'processing' ? '處理中' : '已完成') }}</p>
            <p><strong>聯絡人：</strong>{{ $order->name }}</p>
            <p><strong>聯絡電話：</strong>{{ $order->phone }}</p>
            <p><strong>電子郵件：</strong>{{ $order->email }}</p>
            <p><strong>總金額：</strong>HK${{ number_format($order->price, 2) }}</p>
        </div>
        
        <p>如有任何問題，歡迎隨時聯絡我們：</p>
        <p>📧 客服信箱：support@goprint.com</p>
        <p>📞 客服熱線：+852 1234 5678</p>
        
        <p>再次感謝您的訂購！</p>
        <p>GoPrint 團隊敬上</p>
    </div>
    
    <div class="footer">
        <p>© 2024 GoPrint Hong Kong. All rights reserved.</p>
        <p>This email was sent to {{ $order->email }}</p>
    </div>
</body>
</html>
