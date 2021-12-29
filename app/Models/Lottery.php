<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use User\Models\Country;

/**
 * Class Lottery
 * @package App\Models
 * @property string $name
 * @property int $maximum_winners
 * @property int $creator_id
 * @property Carbon $due_date
 * @property boolean $is_held
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $creator
 * @property-read User $winners
 */

class Lottery extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'maximum_winners',
        'creator_id',
        'due_date',
        'is_held',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'maximum_winners' => 'integer',
        'creator_id' => 'integer',
        'due_date' => 'datetime',
        'is_held' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class,'creator_id','id');
    }

    public function winners()
    {
        return $this->belongsToMany(User::class,'lottery_user')->withTimestamps();
    }



}
