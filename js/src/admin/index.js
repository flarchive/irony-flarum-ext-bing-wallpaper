import app from 'flarum/app';

import WallpaperSettingsModal from './components/WallpaperSettingsModal';

app.initializers.add('irony-bing-wallpaper', app => {
    app.extensionSettings['irony-bing-wallpaper'] = () => app.modal.show(new WallpaperSettingsModal());
});