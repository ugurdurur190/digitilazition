<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Project extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'projects';
    protected $primaryKey= 'id';
    protected $fillable = [
        'user_id',
        'unit_id',
        'title',
        'description',
        'score'
    ];

   
   
}