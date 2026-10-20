<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ !empty($isUpdate) ? 'Updated Article: ' : 'New Article: ' }}{{ $post->title }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #0f172a; color: #334155;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #0f172a; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table width="600" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.25);">
                    
                    <!-- Header with Branding -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #5B4BDB 0%, #4338CA 100%); padding: 32px 40px; text-align: center;">
                            <h2 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 700; letter-spacing: 0.5px;">
                                {{ optional(\App\Models\GeneralSetting::getSettings())->blog_name ?? 'LaraBlog' }}
                            </h2>
                            <p style="color: #c7d2fe; margin: 6px 0 0 0; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                                {{ !empty($isUpdate) ? '📝 Article Updated' : '📬 New Article Published' }}
                            </p>
                        </td>
                    </tr>

                    <!-- Featured Image (if available) -->
                    @if(!empty($post->featured_image))
                    <tr>
                        <td style="padding: 0; text-align: center; background-color: #f8fafc;">
                            <img src="{{ !empty($hasEmbeddedImage) ? 'cid:post_featured_image' : asset('images/posts/' . $post->featured_image) }}" alt="{{ $post->title }}" style="width: 100%; max-height: 280px; object-fit: cover; display: block;" />
                        </td>
                    </tr>
                    @endif
                    
                    <!-- Content Body -->
                    <tr>
                        <td style="padding: 35px 40px;">
                            <!-- Category Badge & Meta -->
                            <div style="margin-bottom: 14px;">
                                <span style="background-color: #EEF2FF; color: #4F46E5; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block;">
                                    {{ optional($post->category)->name ?? 'General' }}
                                </span>
                                <span style="color: #94a3b8; font-size: 13px; margin-left: 10px;">
                                    By {{ optional($post->author)->name ?? 'Admin' }}
                                </span>
                            </div>

                            <!-- Post Title -->
                            <h1 style="color: #1e293b; margin: 0 0 16px 0; font-size: 22px; line-height: 1.4; font-weight: 700;">
                                <a href="{{ $actionLink }}" style="color: #1e293b; text-decoration: none;">
                                    {{ $post->title }}
                                </a>
                            </h1>

                            <!-- Post Excerpt -->
                            <p style="color: #64748b; font-size: 15px; line-height: 1.7; margin: 0 0 28px 0;">
                                {{ $excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 180, '...') }}
                            </p>

                            <!-- CTA Button -->
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" style="border-radius: 10px; background-color: #5B4BDB;">
                                        <a href="{{ $actionLink }}" style="font-size: 15px; font-weight: 600; color: #ffffff; text-decoration: none; padding: 14px 28px; display: inline-block; border-radius: 10px; box-shadow: 0 4px 12px rgba(91, 75, 219, 0.35);">
                                            Read Full Article &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 8px 0; color: #64748b; font-size: 13px;">
                                You are receiving this email because you subscribed to the <strong>{{ optional(\App\Models\GeneralSetting::getSettings())->blog_name ?? 'LaraBlog' }}</strong> newsletter.
                            </p>
                            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                                © {{ date('Y') }} {{ optional(\App\Models\GeneralSetting::getSettings())->blog_name ?? 'LaraBlog' }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
