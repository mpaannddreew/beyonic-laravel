## About this library

This is a simple/basic implementation of beyonic payments in laravel 5

## Actions supported
Note: You must have a valid Beyonic account to use this library
- RECEIVING MONEY [Collection request]
- SENDING MONEY [Payments]

For more information visit [Beyonic](https://apidocs.beyonic.com)

## Installation
git clone https://github.com/mpaannddreew/beyonic-laravel.git

Register service provider
```php
FannyPack\Beyonic\BeyonicServiceProvider::class,
```
Register Facade
Register service provider
```php
'Beyonic' => FannyPack\Beyonic\BeyonicProcessor::class,
```

After the service provider is registered run this command
```
php artisan vendor:publish
```
This command will create a copy of the library's config file and migrations into your code base <pre>beyonic.php</pre>

## Environment setup
The library loads configurations from the .env file in your application's root folder. These are the contents of beyonic.php
```
return [
    'apiKey' => env('BEYONIC_API_KEY', ''),
    'currency' => env('CURRENCY', 'UGX'),
    'callback_url' => env('CALLBACK_URL', 'UGX'),
    'account_id' => env('ACCOUNT_ID', ''),
];
```


## Usage in context of your beyonic account
Requesting payment from a registered mobile money number
```php
$response = Beyonic::deposit($phone_number, $price);
```
Sending payment to a registered mobile money number
```php
$response = Beyonic::withdraw($phone_number, $amount, $reason);
```
For information about the response body visit [Beyonic](https://apidocs.beyonic.com)

## Bugs
For any bugs found, please email me at andrewmvp007@gmail.com or register an issue at [issues](https://github.com/mpaannddreew/beyonic-laravel/issues)
