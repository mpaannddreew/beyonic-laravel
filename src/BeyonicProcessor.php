<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-08-21
 * Time: 4:33 PM
 */

namespace FannyPack\Beyonic;

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
     * BeyonicProcessor constructor.
     * @param Client $client
     * @param Application $app
     */
    public function __construct(Client $client, Application $app)
    {
        $this->client = $client;
        $this->app = $app;
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
     * @param $from
     * @param $amount
     * @return string
     */
    public function deposit($from, $amount)
    {
        $data = [
            "phonenumber" => $from,
            "amount" => $amount,
            "currency" => $this->currency,
            "send_instructions" => True
        ];
        $response = $this->client->post(self::API_URL . 'collectionrequests', ['json' => $data]);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * withdraw to a mobile number
     *
     * @param $to
     * @param $amount
     * @param $reason
     * @return string
     */
    public function withdraw($to, $amount, $reason)
    {
        $data = [
            "phonenumber" => $to,
            "amount" => $amount,
            "currency" => $this->currency,
            "description" => $reason
        ];
        if ($this->account_id)
            $data["account"] = $this-> account_id;

        if ($this->callback_url)
            $data["callback_url"] = $this-> callback_url;

        $response = $this->client->post(self::API_URL . 'payments', ['json' => $data]);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * get a single collection request
     *
     * @param $id
     * @return mixed
     */
    public function info($id)
    {
        $response = $this->client->get(self::API_URL . 'collectionrequests/'. $id);
        return json_decode($response->getBody()->getContents());
    }
}