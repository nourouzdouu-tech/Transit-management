<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE dossiers MODIFY status ENUM('En attente', 'En cours', 'En retard', 'Terminé', 'Bloqué') DEFAULT 'En attente'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE dossiers MODIFY status ENUM('En attente', 'En cours', 'Terminé', 'Bloqué') DEFAULT 'En attente'");
    }
};
