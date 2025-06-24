<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AnonymousUser;
use Symfony\Component\HttpFoundation\Cookie;

class TrackAnonymousUser
{
    public function handle(Request $request, Closure $next)
    {
        $cookieName = 'anon_id';

        // If cookie exists, make sure it's in DB
        if ($request->hasCookie($cookieName)) {
            $anonId = $request->cookie($cookieName);

            // Create DB entry if it doesn't exist
            if (!AnonymousUser::where('anon_id', $anonId)->exists()) {
                AnonymousUser::create(['anon_id' => $anonId]);
            }
        } else {
            // Create new UUID
            $anonId = (string) Str::uuid();

            // Save to DB
            AnonymousUser::create(['anon_id' => $anonId]);

            // Add cookie to response
            $response = $next($request);
            return $response->withCookie(cookie()->forever($cookieName, $anonId));
        }

        return $next($request);
    }
}
