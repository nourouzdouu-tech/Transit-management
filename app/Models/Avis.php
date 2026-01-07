<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $fillable = ['dossier_id', 'client_id', 'note', 'commentaire'];

}
