<?php

namespace App\Traits;

trait HandlePermission
{
    public function hasPermission(): bool
    {
        if ($this->roles->contains('name', 'admin')) {
            return true;
        } else {
            return false;
        }
    }
}
