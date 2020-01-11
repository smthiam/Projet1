<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'settings'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'email_verified_at',
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
     * Get the images.
     */
    public function images()
    {
        return $this->hasMany (Image::class);
    }

    /**
     * User is admin.
     *
     * @return integer
     */
    public function getAdminAttribute()
    {
        return $this->role === 'admin';
    }

    /**
     * Get the adult status.
     *
     * @return boolean
     */
    public function getAdultAttribute()
    {
        return $this->settings->adult;
    }

    /**
     * Get the settings.
     *
     * @param Json $value
     * @return integer
     */
    public function getSettingsAttribute($value)
    {
        return json_decode ($value);
    }

    public function getPaginationAttribute()
    {
        return $this->settings->pagination;
    }

    public function albums()
    {
        return $this->hasMany (Album::class);
    }

    public function setAdultAttribute($value)
    {
        $this->attributes['settings'] = json_encode ([
            'adult' => $value,
            'pagination' => $this->settings->pagination
        ]);
    }
}
