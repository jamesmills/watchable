<?php

namespace JamesMills\Watchable\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{

    protected $table = 'watch';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Watchable model relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function watchable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
