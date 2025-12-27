<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; border-radius: 4px; margin-bottom: 20px; }
        .content { background-color: #ffffff; padding: 20px; border-left: 4px solid #007bff; }
        .footer { margin-top: 20px; font-size: 12px; color: #666; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Phản Hồi từ PetSam</h2>
        </div>
        
        <p>Xin chào <strong>{{ $contact->name }}</strong>,</p>
        
        <p>Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi đã nhận được tin nhắn của bạn về <strong>{{ $contact->subject }}</strong> và rất vui được phản hồi:</p>
        
        <div class="content">
            <h3>Phản Hồi Của Chúng Tôi</h3>
            <p>{!! nl2br(e($responseMessage)) !!}</p>
        </div>
        
        <p style="margin-top: 20px;">Nếu bạn có bất kỳ câu hỏi thêm, vui lòng liên hệ với chúng tôi.</p>
        
        <div class="footer">
            <p>Cảm ơn,<br>
            <strong>{{ config('app.name') }}</strong></p>
        </div>
    </div>
</body>
</html>
