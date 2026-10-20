<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Newsletter!</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #0f172a; color: #334155;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #0f172a; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table width="600" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.25);">
                    
                    <!-- Header with Gradient & Branding -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #5B4BDB 0%, #4338CA 100%); padding: 40px 40px 35px; text-align: center;">
                            <div style="font-size: 38px; line-height: 1; margin-bottom: 12px;">🎉</div>
                            <h1 style="color: #ffffff; margin: 0 0 8px 0; font-size: 24px; font-weight: 800; letter-spacing: 0.5px;">
                                {{ $blogName }}
                            </h1>
                            <p style="color: #c7d2fe; margin: 0; font-size: 14px; letter-spacing: 0.5px;">
                                You're Officially on the List!
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px 45px 35px;">
                            <h2 style="color: #1e293b; margin: 0 0 12px 0; font-size: 20px; font-weight: 700;">
                                Welcome to our community! 🚀
                            </h2>
                            <p style="color: #475569; font-size: 15px; line-height: 1.7; margin: 0 0 24px 0;">
                                Thank you for subscribing to <strong>{{ $blogName }}</strong>. We're thrilled to have you with us! You've just unlocked access to our best content, delivered directly to your inbox.
                            </p>

                            <!-- Feature Card -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 30px;">
                                <tr>
                                    <td style="padding: 22px 25px;">
                                        <p style="margin: 0 0 14px 0; font-weight: 700; color: #1e293b; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Here is what you can look forward to:
                                        </p>
                                        
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="padding: 6px 0; vertical-align: top; width: 24px; font-size: 16px;">📚</td>
                                                <td style="padding: 6px 0 6px 8px; color: #475569; font-size: 14px; line-height: 1.6;">
                                                    <strong style="color: #1e293b;">Curated Articles:</strong> The latest tutorials, guides, and tech stories.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 6px 0; vertical-align: top; width: 24px; font-size: 16px;">💡</td>
                                                <td style="padding: 6px 0 6px 8px; color: #475569; font-size: 14px; line-height: 1.6;">
                                                    <strong style="color: #1e293b;">Weekly Insights:</strong> Actionable tips and best practices from industry writers.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 6px 0; vertical-align: top; width: 24px; font-size: 16px;">✨</td>
                                                <td style="padding: 6px 0 6px 8px; color: #475569; font-size: 14px; line-height: 1.6;">
                                                    <strong style="color: #1e293b;">Zero Spam:</strong> Only high-quality content, no unnecessary fluff.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Call To Action Button -->
                            <div style="text-align: center; margin-bottom: 10px;">
                                <a href="{{ $exploreUrl }}" style="background: linear-gradient(135deg, #5B4BDB 0%, #4338CA 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; padding: 14px 32px; border-radius: 10px; display: inline-block; box-shadow: 0 4px 14px rgba(91, 75, 219, 0.4);">
                                    Explore Latest Articles &rarr;
                                </a>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 6px 0; color: #64748b; font-size: 13px;">
                                Sent to <a href="mailto:{{ $subscriber->email }}" style="color: #5B4BDB; text-decoration: none;">{{ $subscriber->email }}</a> because you signed up on our website.
                            </p>
                            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                                © {{ date('Y') }} {{ $blogName }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
