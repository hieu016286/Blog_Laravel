<?php

namespace App\Traits;

trait HandlePermission
{
    public function hasPermission($permission): bool
    {
        if ($this->roles->contains('name', 'admin')) {
            return true;
        }
        return $this->checkPermissionThroughRole($this->roles, $permission);
    }

    public function checkPermissionThroughRole($roles, $permission): bool
    {
        foreach ($roles as $role) {
            if ($role->permissions->contains('name', $permission)) {
                return true;
            }
        }
        return false;
    }
}
