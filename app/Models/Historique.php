<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory;

    protected $fillable = [
        'dossier_id', 'user_id', 'action', 'description', 'ancien_status', 'nouveau_status'
    ];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}