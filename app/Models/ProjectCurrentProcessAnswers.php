<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ProjectCurrentProcessAnswers extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'project_current_process_answers';
    protected $primaryKey= 'id';
    protected $fillable = [
        'project_id',
        'current_process_id',
        'answer'
    ];
}