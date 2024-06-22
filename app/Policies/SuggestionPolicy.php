<?php

namespace App\Policies;

use App\Models\Suggestion;
use App\Models\User;

class SuggestionPolicy
{

    /**
     * Policy para determinar se o $user pode alterar uma sugestão.
     * De acordo com os requisitos do sistema, apenas administradores
     * podem alterar sugestões pois não há outro tipo de alteração
     * prevista por parte de usuários comuns.
     *
     * @param User $user usuário a ser testado a editar a sugestão
     * @param Suggestion $suggestion sugestão a ser editada. Irrelevante para este caso.
     * @return bool Retorna true se o usuário pode editar a sugestão, false caso contrário.
     */
    public function update(User $user, Suggestion $suggestion): bool
    {
        return $user->admin === 1;
    }

}
