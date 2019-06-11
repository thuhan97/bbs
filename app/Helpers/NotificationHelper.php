<?php


namespace App\Helpers;


use App\Models\Notification;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class NotificationHelper
{
    public static function generateNotify($toId, $title, $content, $fromId, $logoId, $url)
    {
        return [
            'id' => Notification::generateUID(),
            'user_id' => $toId,
            'logo_id' => $logoId,
            'sender_id' => $fromId,
            'title' => $title,
            'content' => $content,
            'data' => $url,
        ];
    }

    public static function sendPushNotification()
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "duaqMxk3vY0:APA91bGoSVaU59CoBOigSjIjMsXcscv9B2KK2qDIDP7YXr6pS0-RLEpkNfmK--4gg0DgygA9r1Yz2smijzFarNKFndB8RjQqE50X-GYFCnetyd45Vb5gFpMBWPyfL_xuZQ-YrAar7M7a";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

//        $downstreamResponse->numberSuccess();
//        $downstreamResponse->numberFailure();
//        $downstreamResponse->numberModification();
//
////return Array - you must remove all this tokens in your database
//        $downstreamResponse->tokensToDelete();
//
////return Array (key : oldToken, value : new token - you must change the token in your database )
//        $downstreamResponse->tokensToModify();
//
////return Array - you should try to resend the message to the tokens in the array
//        $downstreamResponse->tokensToRetry();

    }
}
