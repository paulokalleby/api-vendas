<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository
{
    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function all()
    {
        return  $this->payment
            ->whereActive(true)
            ->orderBy('name')
            ->get();
    }
}
