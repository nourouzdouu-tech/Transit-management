<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero', 'client_id', 'agent_id', 'status', 'description',
        'date_creation', 'date_echeance', 'priorite'
    ];

    protected $casts = [
        'date_creation' => 'datetime',
        'date_echeance' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function historiques()
    {
        return $this->hasMany(Historique::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
  
public function avis()
{
    return $this->hasOne(Avis::class, 'dossier_id');
}

}
