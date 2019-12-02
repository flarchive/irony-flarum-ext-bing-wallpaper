<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->create('irony_bing_wallpaper', function (Blueprint $table) {
            $table->increments('id');                               // ID
            $table->date('enddate');                                // 时间
            $table->string('url');                                  // url
        });
    },
    'down' => function (Builder $schema) {
        $schema->drop('irony_bing_wallpaper');
    },
];
