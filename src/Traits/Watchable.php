<?php

namespace JamesMills\Watchable\Traits;

use JamesMills\Watchable\Models\Watch;

trait Watchable
{
    /**
     * Get a collection of watchers.
     *
     * @return mixed
     */
    public function watchers()
    {
        return $this->morphMany(Watch::class, 'watchable');
    }

    /**
     * Get a collection of user models who watch the given model.
     *
     * @return mixed
     */
    public function collectWatchers()
    {
        $watchers = $this->watchers()
            ->with('user')
            ->get();

        return $watchers->pluck('user');
    }

    /**
     * Set the user as a watcher.
     *
     * @param null|int $user_id
     */
    public function watch($user_id = null)
    {
        $watch = $this->watchers()->firstOrNew([
            'user_id' => $user_id ?? auth()->id(),
        ]);

        $watch->save();
    }

    /**
     * Unwatch the given model for the user.
     *
     * @param null|int $user_id
     */
    public function unwatch($user_id = null)
    {
        $watch = $this->watchers()
            ->where('user_id', '=', $user_id ?? auth()->id())
            ->first();

        if ($watch) {
            $watch->delete();
        }
    }

    /**
     * Toggle the watch state of a user to the model.
     *
     * @param null|int $user_id
     */
    public function toggleWatch($user_id = null)
    {
        if ($this->isWatched($user_id)) {
            $this->unwatch($user_id);
        } else {
            $this->watch($user_id);
        }
    }

    /**
     * Check if a user is watching a model.
     *
     * @param null|int $user_id
     * @return bool
     */
    public function isWatched($user_id = null)
    {
        return (bool) $this->watchers()
            ->where('user_id', '=', $user_id ?? auth()->id())
            ->count();
    }
}
