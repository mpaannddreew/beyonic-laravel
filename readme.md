## About this library

This is a simple/basic implementation of beyonic payments in laravel 5

## Actions supported
Note: You must have a valid Beyonic account to use this library
- RECEIVING MONEY [Collection request]
- SENDING MONEY [Payments]

For more information visit [Beyonic](https://apidocs.beyonic.com)

## Installation
composer require fannypack/beyonic

For Laravel <= 5.4 Register service provider
```php
FannyPack\Beyonic\BeyonicServiceProvider::class,
```
For Laravel <= 5.4 Register Facade
```php
'Beyonic' => FannyPack\Beyonic\Beyonic::class,
```

For Laravel > 5.4 Service provider and Facade are discovered automatically

After the service provider is registered run this command
```php
php artisan vendor:publish
```
This command will create a copy of the library's config file and migrations into your code base 
```php
beyonic.php
```
Run migrations to create beyonic_payments table to store your payment instances
```php
php artisan migrate
```
## Environment setup
The library loads configurations from the .env file in your application's root folder. These are the contents of beyonic.php
```
return [
    'apiKey' => env('BEYONIC_API_KEY', ''),
    'currency' => env('CURRENCY', 'UGX'),
    'callback_url' => env('CALLBACK_URL', ''),
    'account_id' => env('ACCOUNT_ID', ''),
];
```

## Usage in context of your beyonic account
Using it with your models, add trait FannyPack\Beyonic\Billable to your models and make sure your model has a phone_number field
```php
namespace App;

use FannyPack\Beyonic\Billable;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Billable;
}
```

Requesting payment from a billable instance, this method takes an optional phone number in case you want to provide a 
different number to withdraw the funds from and the method returns a FannyPack\Beyonic\Payment::class instance
```php
$account = Account::find(1);
$payment = Beyonic::deposit($account, $amount, $reason, $optional_phone_number);
// or
$payment = $account->deposit($amount, $reason, $optional_phone_number);
```
Information about a Collection request
```php
$response = Beyonic::info($account);
// or
$response = $account->info();
```
Sending payment to th phone number associated with the billable instance, this method takes an optional phone number 
in case you want to provide a different number to deposit the funds to and the method returns a 
FannyPack\Beyonic\Payment::class instance
```php
$payment = Beyonic::withdraw($account, $amount, $reason, $optional_phone_number);
// or
$payment = $account->withdraw($amount, $reason, $optional_phone_number);
```
For information about the response body visit [Beyonic](https://apidocs.beyonic.com)

## Bugs
For any bugs found, please email me at andrewmvp007@gmail.com or register an issue at [issues](https://github.com/mpaannddreew/beyonic-laravel/issues)
