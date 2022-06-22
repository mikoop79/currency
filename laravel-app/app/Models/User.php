<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


/**
 * Class User
 * @package App\Models
 * @property Setting $settings;
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $appends = ['my_currencies'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * @return HasOne
     */
    public function settings(): HasOne
    {
        return $this->hasOne(Setting::class);
    }


    /**
     * @return HasOne
     */
    public function reports(): HasOne
    {
        return $this->hasOne(Report::class);
    }

    /**
     * @return string
     */
    public function getMyCurrenciesAttribute()
    {
        return !empty($this->settings) ? json_encode($this->settings->currencies) : '';
    }
}
