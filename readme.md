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
'Beyonic' => FannyPack\Beyonic\Beyonic::class,
```

After the service provider is registered run this command
```php
php artisan vendor:publish
```
This command will create a copy of the library's config file and migrations into your code base 
```php
beyonic.php
```
Run migrations
```php
php artisan migrate
```
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
Using it with your models, add 
```php
namespace App;

use FannyPack\Beyonic\Billable;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Billable;
}
```

Requesting payment from a registered mobile money number
```php
$response = Beyonic::deposit($from_phone_number, $amount);
```
Information about a Collection request
```php
$response = Beyonic::info($id);
```
Sending payment to a registered mobile money number
```php
$response = Beyonic::withdraw($to_phone_number, $amount, $reason);
```
For information about the response body visit [Beyonic](https://apidocs.beyonic.com)

## Bugs
For any bugs found, please email me at andrewmvp007@gmail.com or register an issue at [issues](https://github.com/mpaannddreew/beyonic-laravel/issues)
