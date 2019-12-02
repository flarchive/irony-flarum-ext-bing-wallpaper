import app from 'flarum/app';

export default function () {
    // 获取透明度
    const transparency = app.data['irony.bing.wallpaper.transparency'] || '0.8';
    // 获取url
    const url = app.data['irony.bing.wallpaper.url'] || '/api/irony/bing/wallpaper';
    $('body').css({
        'background-attachment': 'fixed',
        'background-repeat': 'no-repeat',
        'background-size': '100% 100%',
        '-webkit-background-size': '100% 100%',
        '-o-background-size': '100% 100%',
        'background-image': 'url(' + url + ')'
    });
    if (app.session.user && app.session.user.preferences().fofNightMode) {
        // 夜晚模式
        $('#app').css('background-color', 'rgba(0, 0, 0, ' + transparency + ')');
        $('.App-content').css('background-color', 'rgba(0, 0, 0, 0)');
    } else {
        $('#app').css('background-color', 'rgba(255, 255, 255, ' + transparency + ')');
        $('.App-content').css('background-color', 'rgba(255, 255, 255, 0)');
    }

}