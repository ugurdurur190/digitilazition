<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ProjectPermission extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'project_permissions';
    protected $primaryKey= 'id';
    protected $fillable = [
        'project_id',
        'permission'
    ];
}