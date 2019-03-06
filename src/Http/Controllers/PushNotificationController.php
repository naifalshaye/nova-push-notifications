<?php

namespace Naif\NovaPushNotification\Http\Controllers;

use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Client\Common\HttpMethodsClient;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        Validator::validate([
            'text' => $request->text,
        ], [
            'text' => 'required',
        ]);

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

        $data = [
            'included_segments' => ['All'],
            'contents'          => [
                'en' => $request->text,
            ],
        ];

        if ( ! empty($request->heading)) {
            $data['headings'] = [
                'en' => $request->heading,
            ];
        }

        if ( ! empty($request->url)) {
            $data['url'] = $request->url;
        }

        $response = $oneSignalApi->notifications->add($data);

        return json_encode($response);
    }
}
