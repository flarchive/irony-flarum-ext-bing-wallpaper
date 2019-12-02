<?php

namespace Irony\Bing\Wallpaper;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Flarum\Database\AbstractModel;

class WallpaperModel extends AbstractModel
{
    protected $table = 'irony_bing_wallpaper';
}

class BingWallpaper implements RequestHandlerInterface
{

    private function startsWith($haystack, $needle)
    {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }

    private function getWallpaperJson()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.87 Safari/537.36');
        $headers = [
            'accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'accept-language:zh-CN,zh;q=0.9, en;q=0.8',
            'dnt:1',
            'referer:https://bing.com/',
            'sec-ch-ua:Google Chrome 78',
            'sec-fetch-dest:document',
            'sec-fetch-mode:navigate',
            'sec-fetch-site:same-origin',
            'sec-origin-policy:0',
            'upgrade-insecure-requests:1'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data);
        return $data;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $nowDate = date('Ymd', time());
        $existWallpaper = WallpaperModel::query()->where('enddate', $nowDate)->first();
        if ($existWallpaper) {
            return new RedirectResponse($existWallpaper->url);
        }
        // 获取远程数据并插入数据库
        $data = $this->getWallpaperJson();
        foreach ($data->images as $info) {
            if ($info->enddate == $nowDate) {
                if (!$this->startsWith($info->url, 'http')) {
                    $info->url = 'https://bing.com' . $info->url;
                }
                $existWallpaper = (new WallpaperModel())->forceFill([
                    'enddate' => $nowDate,
                    'url' => $info->url
                ]);
                $existWallpaper->save();
                return new RedirectResponse($info->url);
            }
        }
        return new HtmlResponse('Not Found');
    }

}