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
}