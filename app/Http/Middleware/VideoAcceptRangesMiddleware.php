<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class VideoAcceptRangesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof Response) {
            $contentType = $response->headers->get('Content-Type');

            if (strpos($contentType, 'video/') === 0) {
                $response->headers->set('Accept-Ranges', 'bytes');
            }
        }

        return $response;
    }
}
