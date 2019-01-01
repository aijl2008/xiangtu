<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ArtronController extends Controller
{
    function __invoke($encodedUrl)
    {
        if ($cache = Cache::get($encodedUrl)) {
            $image = Image::make($cache);
            return $image;
        }
        $url = base64_decode($encodedUrl);
        if (!$url) {
            abort(403);
        }
        try {
            $client = new Client();
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Referer' => 'https://news.artron.net/',
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36'
                ]
            ]);
            $data = $response->getBody()->getContents();
            Cache::put($encodedUrl, $data, 60);
            return response($data, 200, [
                'Content-Type' => 'image/png',
            ]);
        } catch (\Exception $e) {
            return response(readfile(base_path("./public/images/default.png")), 200, [
                'Content-Type' => 'image/png',
            ]);
        }

    }
}
