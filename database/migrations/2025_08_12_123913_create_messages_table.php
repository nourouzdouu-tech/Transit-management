<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dossier_id')->constrained()->onDelete('cascade');
            $table->foreignId('expediteur_id')->constrained('users');
            $table->foreignId('destinataire_id')->constrained('users');
            $table->text('contenu');
            $table->boolean('lu')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};