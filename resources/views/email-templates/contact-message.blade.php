<!DOCTYPE html>
<html lang='en' dir='ltr'>
<head>
    <meta charset='UTF-8'>
    <title>New Contact Message</title>
</head>
<body style='margin: 0; padding: 0; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; background-color: #f4f7f6;'>
    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='background-color: #f4f7f6; padding: 40px 0;'>
        <tr>
            <td align='center'>
                <table width='600' border='0' cellspacing='0' cellpadding='0' style='background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);'>
                    
                    <!-- Header -->
                    <tr>
                        <td style='background-color: #4F46E5; padding: 35px 40px; text-align: center;'>
                            <h1 style='color: #ffffff; margin: 0; font-size: 26px; font-weight: 600; letter-spacing: 0.5px;'>New Message Received</h1>
                            <p style='color: #e0e7ff; margin: 10px 0 0 0; font-size: 14px;'>You have a new inquiry from your website</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style='padding: 40px;'>
                            <h2 style='color: #1f2937; margin-top: 0; margin-bottom: 25px; font-size: 20px; border-bottom: 2px solid #f3f4f6; padding-bottom: 15px;'>Contact Details</h2>
                            
                            <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom: 35px;'>
                                <tr>
                                    <td style='padding: 12px 0; border-bottom: 1px solid #f3f4f6; color: #6b7280; font-size: 14px; width: 100px; font-weight: bold;'>Name</td>
                                    <td style='padding: 12px 0; border-bottom: 1px solid #f3f4f6; color: #111827; font-size: 15px; font-weight: 600;'>{{ $name }}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 12px 0; border-bottom: 1px solid #f3f4f6; color: #6b7280; font-size: 14px; width: 100px; font-weight: bold;'>Email</td>
                                    <td style='padding: 12px 0; border-bottom: 1px solid #f3f4f6; font-size: 15px; font-weight: 600;'><a href='mailto:{{ $email }}' style='color: #4F46E5; text-decoration: none;'>{{ $email }}</a></td>
                                </tr>
                                <tr>
                                    <td style='padding: 12px 0; color: #6b7280; font-size: 14px; width: 100px; font-weight: bold;'>Subject</td>
                                    <td style='padding: 12px 0; color: #111827; font-size: 15px; font-weight: 600;'>{{ $subject }}</td>
                                </tr>
                            </table>
                            
                            <h2 style='color: #1f2937; margin-top: 0; margin-bottom: 15px; font-size: 18px;'>Message Content</h2>
                            <div style='background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 25px; color: #374151; font-size: 15px; line-height: 1.7; white-space: pre-wrap;'>{{ $messageContent }}</div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style='background-color: #f9fafb; padding: 25px; text-align: center; border-top: 1px solid #e5e7eb;'>
                            <p style='margin: 0; color: #9ca3af; font-size: 13px;'>This email was automatically generated from your website's contact form.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
