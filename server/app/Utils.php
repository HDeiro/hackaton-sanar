<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

class Utils {
    public static $posts_per_page = 25;
    public static $default_date_format = 'Y-m-d H:i';

    // Defines the default pattern for exception handling
    public static function treatException($ex, $msg = 'Não foi possível atender sua solicitação no momento.', $code = 500) {
        return response()->json([
            'success' => false,
            'msg' => $msg,
            'exception' => [
                'code' => $ex->getCode(),
                'msg' => $ex->getMessage(),
                'line' => $ex->getLine(),
                'file' => $ex->getFile()
            ]
        ], $code);
    }

    // Returns a random string
    public static function random($size = 6) {
        return substr(str_shuffle(str_repeat(
            $x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 
            ceil($size/strlen($x)) 
        )), 1, $size);
    }

    // Debug to SQL
    public static function getSQL(Builder $builder) {
        $addSlashes = str_replace('?', "'?'", $builder->toSql());
        return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
    }
    
    // Send an e-mail
    public static function mail($to, $subject, $message) {
        $mail = new PHPMailer(true);                            

        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Username = env('EMAIL_SENDER_EMAIL');
            $mail->Password = env('EMAIL_SENDER_PASSWORD');
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';
            
            $mail->setFrom(env('EMAIL_SENDER_EMAIL'), env('EMAIL_SENDER_NAME'));
            $mail->addAddress($to);
            // $mail->addCC($to, 'CC');
            $mail->Subject = $subject;
            $template = str_replace('EMAIL_CONTENT', $message, file_get_contents('templates/email.html'));
            
            $mail->msgHTML($template);
            $mail->send();

            return ['success' => true];
        } catch (MailException $e) {
            return Utils::treatException($e, $mail->ErrorInfo);
        }
    }
}