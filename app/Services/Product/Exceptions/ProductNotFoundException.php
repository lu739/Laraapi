<?php

namespace App\Services\Product\Exceptions;
class ProductNotFoundException extends \Exception
{
    public function __construct($message = null, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message ?? __('exceptions.product_not_found'), $code, $previous);
    }
}
