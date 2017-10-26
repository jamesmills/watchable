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
     * Set the current user as a watcher.
     */
    public function watch()
    {
        $watch = $this->watchers()->firstOrNew([
            'user_id' => auth()->id(),
        ]);

        $watch->save();
    }

    /**
     * Unwatch the given model for the current user.
     */
    public function unwatch()
    {
        $watch = $this->watchers()
            ->where('user_id', '=', auth()->id())
            ->first();

        if ($watch) {
            $watch->delete();
        }
    }

    /**
     * Toggle the watch state of a user to the model.
     */
    public function toggleWatch()
    {
        if ($this->isWatched()) {
            $this->unwatch();
        } else {
            $this->watch();
        }
    }

    /**
     * Check if a user is watching a model.
     *
     * @return bool
     */
    public function isWatched()
    {
        return (bool) $this->watchers()
            ->where('user_id', '=', auth()->id())
            ->count();
    }
}
