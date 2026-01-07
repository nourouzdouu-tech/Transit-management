<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->foreignId('client_id')->constrained('users');
            $table->foreignId('agent_id')->nullable()->constrained('users');
            $table->enum('status', ['En attente', 'En cours', 'Terminé', 'Bloqué'])->default('En attente');
            $table->text('description')->nullable();
            $table->datetime('date_creation');
            $table->datetime('date_echeance')->nullable();
            $table->enum('priorite', ['Basse', 'Normale', 'Haute'])->default('Normale');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dossiers');
    }
};