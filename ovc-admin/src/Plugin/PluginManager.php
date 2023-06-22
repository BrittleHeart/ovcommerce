<?php

namespace App\Plugin;

class PluginManager implements PluginInterface
{
    /**
     * @var array<array-key, PluginInterface>
     */
    protected array $plugins = [];

    /**
     * Adds the plugin to the array.
     *
     * @return self is plugin not preset in $plugins
     */
    public function add(PluginInterface $plugin): ?self
    {
        if (in_array($plugin, $this->plugins)) {
            return null;
        }

        $this->plugins[] = $plugin;

        return $this;
    }

    /**
     * Registers all plugins.
     */
    public function register(): void
    {
        foreach ($this->plugins as $plugin) {
            $plugin->register();
        }
    }
}
