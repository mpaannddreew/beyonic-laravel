<?php

namespace FannyPack\Beyonic;

/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-08-01
 * Time: 1:37 PM
 */
trait Billable
{
    /**
     * @return mixed
     */
    public function payments()
    {
        return $this->morphMany(Payment::class, 'billable')->orderBy('id', 'desc');
    }

    /**
     * @param $amount
     * @param string $reason
     * @param null|string $phone_number
     * @return mixed
     */
    public function withdraw($amount, $reason="Payment", $phone_number=null)
    {
        return Beyonic::withdraw($this, $amount, $reason, $phone_number);
    }

    /**
     * @param $amount
     * @param string $reason
     * @param null|string $phone_number
     * @return mixed
     */
    public function deposit($amount, $reason="Payment", $phone_number=null)
    {
        return Beyonic::deposit($this, $amount, $reason, $phone_number);
    }
}