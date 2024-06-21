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
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Usuário que fez a sugestão');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            //
            $table->tinyInteger('status')
                ->unsigned()
                ->default(0)
                ->comment('0 - Pendente, 1 - Aprovada, 2 - Rejeitada, 3 - Em desenvolvimento');

            $table->string('titulo', 90);
            $table->text('descricao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};
