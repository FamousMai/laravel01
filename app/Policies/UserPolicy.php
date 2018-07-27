<?php
/**
 * 用于管理用户模型的授权
 */
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    // 加上 destroy 删除用户动作相关的授权
    public function destroy(User $currentUser, User $user)
    {
        // 规定只有当前用户为管理员，且被删除用户不是自己时，授权才能通过
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
