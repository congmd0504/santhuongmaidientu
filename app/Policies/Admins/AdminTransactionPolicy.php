<?php

namespace App\Policies\Admins;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminTransactionPolicy
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

    public function list(Admin $user)
    {
      //  dd( $user->CheckPermissionAccess(config('permissions.access.transaction-list')));
        return $user->CheckPermissionAccess(config('permissions.access.transaction-list'));
    }
    public function status(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.transaction-status'));
    }

    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.transaction-delete'));
    }
}
