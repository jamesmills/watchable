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
     * @param null|int $userId
     */
    public function watch($userId = null)
    {
        $watch = $this->watchers()->firstOrNew([
            'user_id' => $userId ?? auth()->id(),
        ]);

        $watch->save();
    }

    /**
     * Unwatch the given model for the user.
     *
     * @param null|int $userId
     */
    public function unwatch($userId = null)
    {
        $watch = $this->watchers()
            ->where('user_id', '=', $userId ?? auth()->id())
            ->first();

        if ($watch) {
            $watch->delete();
        }
    }

    /**
     * Toggle the watch state of a user to the model.
     *
     * @param null|int $userId
     */
    public function toggleWatch($userId = null)
    {
        if ($this->isWatched($userId)) {
            $this->unwatch($userId);
        } else {
            $this->watch($userId);
        }
    }

    /**
     * Check if a user is watching a model.
     *
     * @param null|int $userId
     * @return bool
     */
    public function isWatched($userId = null)
    {
        return (bool) $this->watchers()
            ->where('user_id', '=', $userId ?? auth()->id())
            ->count();
    }
}
