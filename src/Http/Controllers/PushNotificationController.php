<?php

namespace Naif\NovaPushNotification\Http\Controllers;

use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Client\Common\HttpMethodsClient;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Illuminate\Http\Request;
use OneSignal\Config as OneSignalConfig;
use OneSignal\OneSignal as OneSignalApi;

class PushNotificationController
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    public function send(Request $request)
    {
        $oneSignalConfig = new OneSignalConfig();
        $oneSignalConfig->setApplicationId(config('push_notifications.app_id'));
        $oneSignalConfig->setApplicationAuthKey(config('push_notifications.api_key'));

        $oneSignalClient = new HttpMethodsClient(
            new GuzzleAdapter(new GuzzleClient()),
            new GuzzleMessageFactory()
        );

        $oneSignalApi = new OneSignalApi(
            $oneSignalConfig,
            $oneSignalClient
        );

        $heading = [
            'en' => $request->heading,
        ];

        $content = [
            'en' => $request->text,
        ];

        $data = [
            'headings'          => $heading,
            'contents'          => $content,
            'included_segments' => ['All'],
        ];

        if ( ! empty($request->url)) {
            $data['url'] = $request->url;
        }

        $response = $oneSignalApi->notifications->add($data);

        return json_encode($response);
    }
}
