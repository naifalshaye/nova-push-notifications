<?php
namespace Naif\NovaPushNotification\Http\Controllers;

use Illuminate\Http\Request;

class PushNotificationController
{
    public function send(Request $request)
    {
        $content = array(
            "en" => $request->text
        );

        $heading = array(
            "en" => $request->heading
        );

        $fields = array(
            'app_id' => config('push_notifications.app_id'),
            'included_segments' => array('All'),
            'data' => array("foo" => "bar"),
            'large_icon' =>"ic_launcher_round.png",
            'contents' => $content,
            'headings' => $heading
        );

        $fields = json_encode($fields);

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Authorization: Basic '.config('push_notifications.api_key')
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $e){
            return $e->getMessage();
        }

        return $response;
    }
}
