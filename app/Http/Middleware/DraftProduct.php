<?php

namespace App\Http\Middleware;

use App\Services\Product\Exceptions\ProductNotFoundException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DraftProduct
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $product = $request->route(param: 'product');
        if ($product->isDraft()) {
            throw new ProductNotFoundException();
        }
        return $next($request);
    }
}
