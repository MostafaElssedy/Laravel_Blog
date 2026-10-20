<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CMail
{
    /**
     * Send email using PHPMailer
     *
     * @param array $config Array containing 'recipient_address', 'recipient_name', 'subject', and 'body'
     * @return bool
     */
    public static function send($config)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0; // Disable verbose debug output
            $mail->isSMTP();
            $mail->Host       = config('services.mail.host');
            $mail->SMTPAuth   = true;
            $mail->Username   = config('services.mail.username');
            $mail->Password   = config('services.mail.password');
            $mail->SMTPSecure = config('services.mail.encryption');
            $mail->Port       = config('services.mail.port');

            // Recipients
            $mail->setFrom(
                isset($config['from_address']) ? $config['from_address'] : config('services.mail.from_address'),
                isset($config['from_name']) ? $config['from_name'] : config('services.mail.from_name')
            );

            if (!empty($config['recipient_address'])) {
                $mail->addAddress($config['recipient_address'], isset($config['recipient_name']) ? $config['recipient_name'] : null);
            }

            // Embedded Images
            if (!empty($config['embedded_images']) && is_array($config['embedded_images'])) {
                foreach ($config['embedded_images'] as $img) {
                    if (!empty($img['path']) && file_exists($img['path'])) {
                        $mail->addEmbeddedImage($img['path'], $img['cid'], $img['name'] ?? '');
                    }
                }
            }

            // Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = 'UTF-8';                             //Set charset to UTF-8 for Arabic/Unicode support
            $mail->Subject = $config['subject'];
            $mail->Body    = $config['body'];

            if( !$mail->send() ) {
                return false;
            }else{
                return true;
            }
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error("CMail SMTP Exception: " . $e->getMessage());
            return false;
        }
    }
}
