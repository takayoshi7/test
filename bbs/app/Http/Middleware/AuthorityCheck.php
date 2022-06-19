<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class AuthorityCheck
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
        //ログインユーザーのid取得
        $user = Auth::user()->empno;
        //ログインユーザーの役割と権限を取得
        $role_data = DB::table('emp')
            ->select('authority_id', 'roles.name')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->join('authority_role', 'roles.id', '=', 'role_id')
            ->where('empno', '=', $user)->get();
        //多次元配列になったstdClassをArrayにキャスト
        $encode = json_decode(json_encode($role_data), true);
        //多次元配列を一次元配列に変換
        $array = Arr::flatten($encode);
        //ログインユーザーの役割のみ取得
        $roles_name = $encode[0]['name'];

        $request->merge(['array'=>$array, 'roles_name'=>$roles_name]);

        return $next($request);
    }
}
