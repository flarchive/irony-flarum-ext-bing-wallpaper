<?php

namespace Irony\Bing\Wallpaper;

use Flarum\Extend;

return [
    (new Extend\Frontend('forum'))
        ->css(__DIR__ . '/resources/less/forum.less'),
    (new Extend\Routes('api'))
        ->get('/irony/bing/wallpaper', 'irony.bing.wallpaper', BingWallpaper::class)
];
