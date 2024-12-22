<?php

namespace App\Services;

use App\Repositories\PaymentRepository;

class PaymentService
{
    protected $payment;

    public function __construct(PaymentRepository $payment)
    {
        $this->payment = $payment;
    }

    public function getAllPayments(array $filters)
    {
        return $this->payment->all($filters);
    }
}
