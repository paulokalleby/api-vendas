<?php

use Carbon\Carbon;

function price($value)
{
    return number_format($value, 2, ',', '.');
}


function total($items)
{
    $total = 0;

    foreach ($items as $item) {
        $total += ($item->pivot->price * $item->pivot->quantity);
    }

    return $total;
}


function totalFloat($items)
{
    $total = 0;

    foreach ($items as $item) {
        $total += ($item->price * $item->quantity);
    }

    return $total;
}

function totalItems($items)
{
    $total = 0;

    foreach ($items as $item) {
        $total += ($item->price * $item->quantity);
    }

    return $total;
}
