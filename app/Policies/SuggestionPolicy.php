<?php

namespace App\Policies;

use App\Models\Suggestion;
use App\Models\User;

class SuggestionPolicy
{

    /**
     * Determina se o usuario pode alterar uma sugestao
     */
    public function update(User $user, Suggestion $suggestion): bool
    {
        return $user->admin === 1;
    }

}
