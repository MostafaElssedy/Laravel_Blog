<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Changed Successfully</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 0; padding: 0; }
        .email-wrapper { width: 100%; background-color: #f4f6f9; padding: 40px 0; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); }
        .email-header { background-color: #28a745; padding: 30px 20px; text-align: center; color: #ffffff; }
        .email-header h2 { margin: 0; font-size: 24px; font-weight: 600; }
        .email-body { padding: 40px 30px; color: #333333; line-height: 1.6; }
        .email-body p { margin-bottom: 20px; font-size: 16px; }
        .email-footer { background-color: #f9f9f9; padding: 20px; text-align: center; color: #888888; font-size: 13px; border-top: 1px solid #eeeeee; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                <h2>Password Changed Successfully</h2>
            </div>
            <div class="email-body">
                <p>Hello <strong>{{ $user->name }}</strong>,</p>
                <p>This email is to confirm that the password for your account has been successfully updated.</p>
                <p>If you made this change, you can safely ignore this email.</p>
                <p style="color: #dc3545; font-weight: 600;">If you did not make this change, please contact our support team immediately to secure your account.</p>
            </div>
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
