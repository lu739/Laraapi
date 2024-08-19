<?php

namespace App\Http\Middleware;

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
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
        return $next($request);
    }
}
