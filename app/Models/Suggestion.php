<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        // Evento de criação de sugestão, setando
        // automaticamente o ID do usuário logado
        static::creating(function ($model) {
            if(auth()->check()) {
                $model->user_id = auth()->user()->id;
            }
        });
    }
}
