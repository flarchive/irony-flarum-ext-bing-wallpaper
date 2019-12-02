<?php

namespace Irony\Bing\Wallpaper;

use Flarum\Frontend\Document;
use Flarum\Settings\SettingsRepositoryInterface;

class BingWallpaperSettings
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    protected $prefix = 'irony.bing.wallpaper.';

    protected $keys = ['transparency', 'url'];

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke(Document $document)
    {
        foreach ($this->keys as $key) {
            $document->payload[$this->prefix . $key] = $this->settings->get($this->prefix . $key);
        }
    }

}