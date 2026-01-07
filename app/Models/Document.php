<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'dossier_id', 'nom', 'chemin', 'type', 'taille', 'uploaded_by'
    ];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}