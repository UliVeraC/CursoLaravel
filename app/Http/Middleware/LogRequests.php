<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = [
            'url' => $request->fullurl(),
            'ip' => $request->ip(),
            'method'=> $request->method(),

            'headers' => $request->headers->all(),
            'body' => $request->getContent(),
        ];

        //dd($data);
        Log::info('Solicitud recibida: ', $data);

        return $next($request);
    }

    public function terminate(Request $request, Response $response){
        Log::info('Respuesta enviada: ', [
            "status" => $response->getStatusCode(),
            "content" => $response->getContent()
        ]);

    }
}
