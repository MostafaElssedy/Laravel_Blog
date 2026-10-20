<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 0; padding: 0; }
        .email-wrapper { width: 100%; background-color: #f4f6f9; padding: 40px 0; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); }
        .email-header { background-color: #1b00ff; padding: 30px 20px; text-align: center; color: #ffffff; }
        .email-header h2 { margin: 0; font-size: 24px; font-weight: 600; }
        .email-body { padding: 40px 30px; color: #333333; line-height: 1.6; }
        .email-body p { margin-bottom: 20px; font-size: 16px; }
        .btn-wrapper { text-align: center; margin: 35px 0; }
        .btn { display: inline-block; padding: 14px 30px; background-color: #1b00ff; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 16px; }
        .link-fallback { word-break: break-all; color: #1b00ff; font-size: 14px; }
        .email-footer { background-color: #f9f9f9; padding: 20px; text-align: center; color: #888888; font-size: 13px; border-top: 1px solid #eeeeee; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                <h2>Password Reset Request</h2>
            </div>
            <div class="email-body">
                <p>Hello <strong>{{ $user->name }}</strong>,</p>
                <p>We received a request to reset the password for your account. If you made this request, please click the button below to choose a new password.</p>
                
                <div class="btn-wrapper">
                    <a href="{{ $actionLink }}" class="btn">Reset My Password</a>
                </div>
                
                <p>If you did not request a password reset, no further action is required and you can safely ignore this email.</p>
                
                <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
                
                <p style="font-size: 14px; color: #666;">If you're having trouble clicking the "Reset My Password" button, copy and paste the URL below into your web browser:</p>
                <p class="link-fallback"><a href="{{ $actionLink }}">{{ $actionLink }}</a></p>
            </div>
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
