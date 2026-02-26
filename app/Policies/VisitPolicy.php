<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Visit;

class VisitPolicy
{
    public function view(User $user, Visit $visit)
    {
        // Admin can view all, staff can view their own
        return $user->isAdmin || $user->id === $visit->user_id;
    }

    public function update(User $user, Visit $visit)
    {
        // Only draft visits can be edited, only by owner or admin
        return $visit->status === 'draft' && ($user->isAdmin || $user->id === $visit->user_id);
    }

    public function delete(User $user, Visit $visit)
    {
        // Admin can delete any, staff can only delete their own
        return $user->isAdmin || $user->id === $visit->user_id;
    }
}
