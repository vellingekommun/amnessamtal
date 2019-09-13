<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }


}



