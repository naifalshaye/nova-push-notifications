# Laravel Nova Push Notifications
A Laravel Nova tool to send push notifications. Currently supporting just via OneSignal

## Installation:
You can install nova push notifications package in to a Laravel app that uses Nova via composer:
```bash
composer require naif/nova-push-notification
```

## Configuration
Publish the package config file:
```bash
php artisan vendor:publish --provider="Naif\NovaPushNotification\ToolServiceProvider"
```

Configuration will be published at [config/push_notifications.php].


Add the following keys to your `.env` and `.env.example`:
```bash
PUSH_APP_ID=
PUSH_API_KEY=
```

## Usage
Add the below to the tools function in app/Providers/NovaServiceProvider.php

```bash
public function tools()
{
  return [
    new NovaPushNotification(),
  ];
}
```

![Package screenshot](https://raw.githubusercontent.com/naifalshaye/nova-push-notifications/master/screenshots/screen1.png)

![Package screenshot](https://raw.githubusercontent.com/naifalshaye/nova-push-notifications/master/screenshots/screen2.png)


## Support:
naif@naif.io

https://www.linkedin.com/in/naif

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
