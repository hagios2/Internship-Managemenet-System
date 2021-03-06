<?php

namespace App;

/* use SMartins\PassportMultiauth\HasMultiAuthApiTokens; */
use App\Notifications\MainCordinatorResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class MainCordinator extends Authenticatable
{
    use Notifiable/* , HasMultiAuthApiTokens */;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'device_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MainCordinatorResetPassword($token));
    }

    public function message()
    {
        return $this->hasMany('App\Message');
    }

    public function addMessage($message)
    {
        return $this->message()->create($message);
    }
}
