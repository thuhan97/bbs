<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSSProtected
{
    const IGNORE_TAGS = [
        'content',
        'detail',
        'description',
        'tools',
        'technicala',
        'html_',
    ];

    public function handle(Request $request, Closure $next)
    {
        $input = $request->input();
        array_walk_recursive($input, function (&$input, $key) {
            if (starts_with($key, self::IGNORE_TAGS)) {
                return;
            }
            if (!is_null($input))
                $input = e(strip_tags($input));
        });

        $request->merge($input);
        return $next($request);
    }
}