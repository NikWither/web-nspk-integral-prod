<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Cookie;

class EnsureSessionCookies
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (! $request->hasSession()) {
            return $response;
        }

        $session = $request->session();

        if (! $session->isStarted()) {
            $session->start();
        }

        $session->save();

        $config = config('session');

        $this->queueSessionCookie($response, $session->getName(), $session->getId(), $config, true);

        if ($token = $session->token()) {
            $this->queueSessionCookie($response, 'XSRF-TOKEN', $token, $config, false);
        }

        Log::debug('EnsureSessionCookies headers', [
            'cookies' => array_map(fn (Cookie $cookie) => $cookie->getName().'='.$cookie->getValue(), $response->headers->getCookies()),
        ]);

        return $response;
    }

    private function queueSessionCookie($response, string $name, string $value, array $config, bool $httpOnly): void
    {
        $lifetime = Arr::get($config, 'lifetime', 0);
        $expiry = $lifetime ? now()->addMinutes($lifetime) : 0;
        $domain = $config['domain'] ?: null;
        $secure = $config['secure'] ?? false;
        $sameSite = $config['same_site'] ?? null;
        $partitioned = $config['partitioned'] ?? false;
        $path = $config['path'] ?? '/';

        $cookie = new Cookie(
            $name,
            $value,
            $expiry,
            $path,
            $domain,
            $secure,
            $httpOnly,
            false,
            $sameSite,
            $partitioned
        );

        $response->headers->setCookie($cookie);

        // Ensure the cookie is also sent via PHP's native API for FastCGI environments.
        setcookie(
            $name,
            $value,
            [
                'expires' => $expiry instanceof \DateTimeInterface ? $expiry->getTimestamp() : $expiry,
                'path' => $path,
                'domain' => $domain,
                'secure' => $secure,
                'httponly' => $httpOnly,
                'samesite' => $sameSite,
            ]
        );
    }
}
