<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class FormQuestion extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'form_questions';
    protected $primaryKey= 'id';
    protected $fillable = [
        'form_id',
        'question',
        'frm_option',
        'type'
    ];
   
}