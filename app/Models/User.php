<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone','ville', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function dossiers()
    {
        return $this->hasMany(Dossier::class, 'client_id');
    }
    

    public function isAgent()
    {
        return $this->role === 'agent';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }
    public function notificationsNonLues()
{
    return $this->unreadNotifications;
}
public function historiques()
{
    return $this->hasMany(Historique::class);
}
public function receivedMessages()
{
    return $this->hasMany(Message::class, 'destinataire_id');
}

}