<?php

namespace App\Business\Services;
use App\Business\Entities\Taxes;

class ProductService
{
    public function calculatePriceWithTax($price)
    {
        return $price + ($price * Taxes::IVA);
    }
}
