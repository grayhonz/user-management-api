<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log incoming request
        $this->logRequest($request);
        
        // Continue with the request
        $response = $next($request);
        
        // Log response
        $this->logResponse($request, $response);
        
        return $response;
    }
    
    /**
     * Log the request details
     */
    protected function logRequest(Request $request): void
    {
        $logData = [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->header('User-Agent'),
            'input' => $request->except(['password']),
        ];
        
        Log::channel('api')->info('REQUEST', $logData);
    }
    
    /**
     * Log the response details
     */
    protected function logResponse(Request $request, Response $response): void
    {
        $logData = [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'status' => $response->getStatusCode(),
        ];
        
        Log::channel('api')->info('RESPONSE', $logData);
    }
}