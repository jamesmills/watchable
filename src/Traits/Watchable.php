<?php

namespace JamesMills\Watchable\Traits;

use JamesMills\Watchable\Models\Watch;

trait Watchable
{
    /**
     * Get all of the model watchers.
     */
    public function watchers()
    {
        return $this->morphMany(Watch::class, 'watchable');
    }

    public function collectWatchers()
    {
        $watchers = $this->watchers()
            ->with('user')
            ->get();

        return $watchers->pluck('user');
    }

    public function watch()
    {
        $watch = $this->watchers()->firstOrNew([
            'user_id' => auth()->id()
        ]);

        $watch->save();
    }

    public function unwatch()
    {
        $watch = $this->watchers()
            ->where('user_id', '=', auth()->id())
            ->first();

        if ($watch) {
            $watch->delete();
        }
    }

    public function toggleWatch()
    {
        if ($this->isWatched()) {
            $this->unwatch();
        } else {
            $this->watch();
        }
    }

    public function isWatched()
    {
        return (bool)$this->watchers()
            ->where('user_id', '=', auth()->id())
            ->count();
    }
}
