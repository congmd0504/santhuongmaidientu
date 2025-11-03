<?php

namespace App\Policies\Admins;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminCodeSalePolicy
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
        return $user->CheckPermissionAccess(config('permissions.access.code_sale-list'));
    }
    public function add(Admin $user)
    {
      //  dd( $user->CheckPermissionAccess(config('permissions.access.transaction-list')));
        return $user->CheckPermissionAccess(config('permissions.access.code_sale-add'));
    }
    public function edit(Admin $user)
    {
      //  dd( $user->CheckPermissionAccess(config('permissions.access.transaction-list')));
        return $user->CheckPermissionAccess(config('permissions.access.code_sale-edit'));
    }

    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.code_sale-delete'));
    }
}
