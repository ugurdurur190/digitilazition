<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ProjectCommit extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'project_commits';
    protected $primaryKey= 'id';
    protected $fillable = [
        'project_id',
        'todo_id',
        'user_id',
        'commit'
    ];    
  
}