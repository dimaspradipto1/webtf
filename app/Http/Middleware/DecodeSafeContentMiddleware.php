<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DecodeSafeContentMiddleware
{
    /**
     * Decode any input field starting with B64_SAFE: to prevent LiteSpeed Web Server / ModSecurity 403 Forbidden.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH')) {
            $toMerge = [];
            foreach ($request->keys() as $key) {
                $val = $request->input($key);
                if (is_string($val) && str_starts_with($val, 'B64_SAFE:')) {
                    $decoded = base64_decode(substr($val, 9), true);
                    if ($decoded !== false) {
                        $toMerge[$key] = $decoded;
                    }
                }
            }
            if (!empty($toMerge)) {
                $request->merge($toMerge);
            }
        }

        return $next($request);
    }

    protected function decodeArray(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->decodeArray($value);
            } elseif (is_string($value) && str_starts_with($value, 'B64_SAFE:')) {
                $b64 = substr($value, 9);
                $decoded = base64_decode($b64, true);
                if ($decoded !== false) {
                    $data[$key] = $decoded;
                }
            }
        }

        return $data;
    }
}
