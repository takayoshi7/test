<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncementPolicy
{
    use HandlesAuthorization;

    public function boot()
    {
        try {
            Authority::get()->map(function ($perm) {
                Gate::define($perm->name, function ($user) use ($perm) {
                    return $user->hasAuthority($perm->name);
                });
            });
        } catch (\Exception $e) {
            Log::error(__FILE__ . " (" . __LINE__ . ")" . PHP_EOL . $e->getMessage());
            return false;
        }

        Blade::directive('role', function ($role) {
            return "if(auth()->check() && auth()->user()->hasRole({$role})) :";
        });

        Blade::directive('endrole', function ($role) {
            return "endif;";
        });
    }

    // /* 閲覧 */
    // public function view(User $emp)
    // {
    //     $user_types = [
    //         '1', // 管理者
    //         '10',  // 役員
    //         '20' // 人事
    //     ];
    //     return (in_array($emp->role, $user_types));
    // }

    // /* 追加 */
    // public function create(User $emp)
    // {
    //     $user_types = [
    //         '1', // 管理者
    //         '20'   // 人事
    //     ];
    //     return (in_array($emp->role, $user_types));
    // }

    // /* 変更 */
    // public function update(User $emp)
    // {
    //     $user_types = [
    //         '1', // 管理者
    //         '20'   // 人事
    //     ];
    //     return (in_array($emp->role, $user_types));
    // }
}
