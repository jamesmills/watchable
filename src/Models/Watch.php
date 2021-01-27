<?php

namespace JamesMills\Watchable\Models;

use Illuminate\Database\Eloquent\Model;
use JamesMills\Watchable\Events\ModelWasWatched;
use JamesMills\Watchable\Events\ModelWasUnWatched;

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
     * The event map for the model.
     *
     * @var array
     */
    protected $events = [
        'saved' => ModelWasWatched::class,
        'deleted' => ModelWasUnWatched::class,
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

    /**
     * User model relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
