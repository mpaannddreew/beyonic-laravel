<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-08-21
 * Time: 4:33 PM
 */

namespace FannyPack\Beyonic;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
class BeyonicProcessor
{
    /**
     * @var Client
     */
    private $client;

    CONST API_URL = "https://app.beyonic.com/api/";

    /**
     * @var Application
     */
    private $app;

    /**
     * @var
     */
    private $currency;

    /**
     * @var
     */
    private $callback_url;

    /**
     * @var
     */
    private $account_id;

    /**
     * @var Carbon
     */
    private $time;

    /**
     * BeyonicProcessor constructor.
     * @param Client $client
     * @param Application $app
     * @param Carbon $time
     */
    public function __construct(Client $client, Application $app, Carbon $time)
    {
        $this->client = $client;
        $this->app = $app;
        $this->time = $time;
        $this->setOptions();
    }

    /**
     * configure required settings
     */
    private function setOptions()
    {
        $this->currency = $this->app['config']['beyonic.currency'];
        if (!$this->currency)
            throw new \InvalidArgumentException("currency is not specified");
        $this->callback_url = $this->app['config']['beyonic.callback_url'];
        $this->account_id = $this->app['config']['beyonic.account_id'];
    }

    /**
     * deposit to a beyonic account
     *
     * @param $billable
     * @param $amount
     * @param string $reason
     * @param null|string $phone_number
     * @return Payment
     */
    public function withdraw($billable, $amount, $reason="Payment", $phone_number=null)
    {
        $phone_number = is_null($phone_number) ? $billable->phone_number: $phone_number;
        $data = [
            "phonenumber" => $phone_number,
            "amount" => $amount,
            "currency" => $this->currency,
            "send_instructions" => True
        ];

        $response = $this->client->post(self::API_URL . 'collectionrequests', ['json' => $data]);

        $response = json_decode($response->getBody()->getContents());

        return $billable->payments()->create([
            'transaction_id' => $response->id,
            'initiated_at' => $this->time->now($this->time->getTimezone()),
            'amount' => $amount,
            'phone_number' => $phone_number,
            'reason' => $reason
        ]);
    }

    /**
     * withdraw to a mobile number
     *
     * @param $billable
     * @param $amount
     * @param string $reason
     * @param null|string $phone_number
     * @return Payment
     */
    public function deposit($billable, $amount, $reason="Payment", $phone_number=null)
    {
        $phone_number = is_null($phone_number) ? $billable->phone_number: $phone_number;
        $data = [
            "phonenumber" => $phone_number,
            "amount" => $amount,
            "currency" => $this->currency,
            "description" => $reason
        ];
        if ($this->account_id)
            $data["account"] = $this-> account_id;

        if ($this->callback_url)
            $data["callback_url"] = $this-> callback_url;

        $response = $this->client->post(self::API_URL . 'payments', ['json' => $data]);

        $response = json_decode($response->getBody()->getContents());

        return $billable->payments()->create([
            'transaction_id' => $response->id,
            'initiated_at' => $this->time->now($this->time->getTimezone()),
            'amount' => $amount,
            'phone_number' => $phone_number,
            'reason' => $reason
        ]);
    }

    /**
     * get a single collection request
     *
     * @param Payment $payment
     * @return string
     */
    public function info(Payment $payment)
    {
        $response = $this->client->get(self::API_URL . 'collectionrequests/'. $payment->transaction_id);
        return json_decode($response->getBody()->getContents());
    }
}