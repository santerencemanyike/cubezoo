<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Site;

class SitePolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Site $site)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->isAdmin;
    }

    public function update(User $user, Site $site)
    {
        return $user->isAdmin;
    }

    public function delete(User $user, Site $site)
    {
        return $user->isAdmin;
    }
}
