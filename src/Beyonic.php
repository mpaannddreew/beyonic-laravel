<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-07-31
 * Time: 2:42 PM
 */

namespace FannyPack\Beyonic;


use Illuminate\Support\Facades\Facade;

class Beyonic extends Facade
{
    public static function getFacadeAccessor()
    {
        return BeyonicProcessor::class;
    }
}