<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('suggestion_id');

            // Apesar de um registro nesta tabela ja fica implicito um voto, prefiro deixar o default 0
            // e contabilizar um voto de fato apenas em registros com vote = 1
            $table->tinyInteger('vote')->default(0)->comment('1: Voto positivo');

            //
            $table->timestamps();

            //
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('suggestion_id')
                ->references('id')
                ->on('suggestions');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_votes');
    }
};
