<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ProjectCurrentProcess extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'project_current_processes';
    protected $primaryKey= 'id';
    protected $fillable = [
        'project_id',
        'process',
        'title'
    ];

   
   
}