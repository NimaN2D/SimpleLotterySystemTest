<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property string $email
 * @property string $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|User customer()
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'type',
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

    protected $with = [
        'lottery'
    ];

    public function createdLotteries()
    {
        return $this->hasMany(Lottery::class, 'creator_id', 'id');
    }

    public function lottery()
    {
        return $this->belongsToMany(Lottery::class, 'lottery_user')->withTimestamps();
    }

    public function scopeCustomer($query)
    {
        /**@var $query Builder*/
        $query->where('type',CUSTOMER_TYPE);
    }

    /**
     * Mutators
     */
    public function getFullNameAttribute()
    {
        return ucfirst($this->attributes['first_name']) . ' ' . ucfirst($this->attributes['last_name']);
    }

    public function getLotteryNameAttribute()
    {
        if($this->lottery()->exists())
            return $this->lottery()->first()->name;

        return '---';
    }

    public function getLotteryWinDateAttribute()
    {
        if($this->lottery()->exists())
            return $this->lottery()->first()->updated_at;

        return '---';
    }

}
