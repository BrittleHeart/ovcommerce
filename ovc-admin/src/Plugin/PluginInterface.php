<?php

namespace App\Plugin;

interface PluginInterface
{
    /**
     * Register method is used for plugin registration and for it's actions
     * This lets us better manage plugins.
     */
    public function register(): void;
}
