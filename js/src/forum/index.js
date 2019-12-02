import {extend} from "flarum/extend";
import app from 'flarum/app';
import Page from 'flarum/components/Page';
import TagsPage from 'flarum/tags/components/TagsPage';
import changeWallpaper from './changeWallpaper';

app.initializers.add('irony-bing-wallpaper', app => {

    extend(Page.prototype, 'init', function () {
        changeWallpaper();
    });

    if (TagsPage) {
        extend(TagsPage.prototype, 'config', function () {
            changeWallpaper();
        });
    }


});
