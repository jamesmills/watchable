<?php

namespace JamesMills\Watchable;

use CreateWatchTable;
use Illuminate\Support\ServiceProvider;

class WatchableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        if (!class_exists(CreateWatchTable::class)) {
            $timestamp = date('Y_m_d_His');

            $this->publishes([
                __DIR__ . '/../migrations/create_watch_table.php' => database_path("/migrations/{$timestamp}_create_watch_table.php"),
            ], 'migrations');
        }
    }
}
