<?php

namespace common\components;

use Yii;
use yii\base\Component;

/*
 * Globals Components for global functions
 */
class Globals extends Component
{
    CONST VERSION 	    = '0.0.1';
    CONST USER_PASSWORD = '123456';
    CONST SENDER_ID 	= 'PROZOO';
    public static $SMS_URL = 'http://www.smsjust.com/blank/sms/user/urlsms.php';

    public static function sendSMS($message, $recipient) {
        // Check for client's internet connectivity
        if(connection_aborted() == 1) {
            throw new CHttpException(408, 'Internet connectivity not available.');
        }

        if (!isset($recipient) && $recipient == '') {
            throw new CHttpException(400, 'Empty recipient-list.');
        }

        try {
            $sms_return = @file_get_contents(self::$SMS_URL . '?username=' . self::USERNAME . '&pass=' . self::USER_PASSWORD . '&senderid=' . self::SENDER_ID . '&dest_mobileno=' . $recipient . '&message='.urlencode($message).'&response=Y');

            if ($sms_return == false) {
                throw new CHttpException(404, 'URL not found.');
            }
        } catch (Exception $e) {
            throw new CHttpException(500, 'Something went wrong while sending SMS.');
        }
    }

    public static function sendMailWithAttachment($template, $data, $from, $to, $subject, $attachFilePath, $cc=[])
    {
        $message = Yii::$app->mailer->compose(['html' => $template], $data);
        $message->setFrom($from)
            ->setTo($to)
            ->setCc($cc)
            ->setSubject($subject);
        if(is_array($attachFilePath)){
            foreach($attachFilePath as $eachFile){
                $message->attach($eachFile);
            }
        } else {
            $message->attach($attachFilePath);
        }

        $mail = $message->send();
        return $mail;
    }
}