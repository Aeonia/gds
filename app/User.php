<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'public_name', 'email', 'password', 'level'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    /**
     * Get the public name for the user if it exists;
     * get the regular name otherwise.
     */
    public function who()
    {
        return (
            $this->public_name !== null
        ) ? (
            $this->public_name
        ) : (
            $this->name
        );
    }

    public static function nickFury()
    {
        return User::where('level', 10)->first();
    }
}
