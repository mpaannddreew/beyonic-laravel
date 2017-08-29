<?php

namespace FannyPack\Beyonic;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $casts = [
        'initiated_at' => 'datetime',
        'approved' => 'boolean',
        'payment_details' => 'array'
    ];
    
    protected $table = "beyonic_payments";

    protected $fillable = ['transaction_id', 'initiated_at', 'approved', 'amount', 'phone_number', 'reason', 'payment_details'];
    
    /**
     * Get the billable entity that the payment belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function billable()
    {
        return $this->morphTo();
    }
}
