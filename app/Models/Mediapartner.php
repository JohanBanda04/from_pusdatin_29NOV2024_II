<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Mediapartner extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "mediapartner";
    protected $primaryKey = "id_media";

//    protected $fillable = [
//
//        'nama_media',
//        'email_media',
//        'password',
//        'no_hp',
//        'roles',
//
//    ];

    protected $guarded = [
        'id_media',
        'kode_media',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
