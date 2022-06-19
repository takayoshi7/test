<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class MailSend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        // \Log::debug(json_decode(json_encode($response),true));
        $decode = json_decode(json_encode($response),true);
        $data = $decode['original'];

        if ($data === true) {
            $name = Auth::user()->ename;
            $email = $request->email;

            Mail::send(new TestMail($name, $email));
        }

        return $response;
    }
}
