<?php

namespace App\Console\Commands;

use App\Models\Classification;
use App\Models\Video;
use App\Models\Wechat;
use Faker\Factory as Faker;
use Illuminate\Console\Command;

class Demo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '填充演示数据';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Wechat::query()->getConnection()->table('followed_wechat')->truncate();
        Wechat::query()->getConnection()->table('video_wechat')->truncate();
        Wechat::query()->truncate();
        Video::query()->truncate();
        Classification::query()->truncate();

        foreach ([
                     [
                         'name' => '社会',
                         'icon' => 'fa-newspaper-o'
                     ],
                     [
                         'name' => '搞笑',
                         'icon' => 'fa-cube'
                     ],
                     [
                         'name' => '生活',
                         'icon' => 'fa-glass'
                     ],
                     [
                         'name' => '影视',
                         'icon' => 'fa-film'
                     ],
                     [
                         'name' => '娱乐',
                         'icon' => 'fa-coffee'
                     ],
                     [
                         'name' => '音乐',
                         'icon' => 'fa-music'
                     ],
                     [
                         'name' => '舞蹈',
                         'icon' => 'fa-female'
                     ],
                     [
                         'name' => '游戏',
                         'icon' => 'fa-gamepad'
                     ]
                     ,
                     [
                         'name' => '美食',
                         'icon' => 'fa-lemon-o'
                     ]
                     ,
                     [
                         'name' => '旅行',
                         'icon' => 'fa-plane'
                     ]
                     ,
                     [
                         'name' => '时尚',
                         'icon' => 'fa-industry'
                     ]
                     ,
                     [
                         'name' => '科技',
                         'icon' => 'fa-desktop'
                     ]
                     ,
                     [
                         'name' => '运动',
                         'icon' => 'fa-futbol-o'
                     ]
                 ] as $item) {
            Classification::query()->create(
                [
                    'name' => $item['name'],
                    'icon' => $item['icon'],
                    'status' => 1
                ]
            );
        }
        $cover = 0;
        $avatar = 0;
        $faker = Faker::create('zh_CN');
        for ($i = 0; $i < 100; $i++) {
            if ($avatar >= 100) {
                $avatar = 0;
            }
            $wechat = new Wechat(
                [
                    "open_id" => config('wechat.mini_program.default.app_id') . '|' . $faker->regexify('[0-9A-Z]{32}'),//18+1+42
                    "union_id" => null,
                    "avatar" => "http://www.xiangtu.net.cn/avatar/" . ++$avatar . '.jpg',
                    "nickname" => $faker->name,
                    "sex" => $faker->numberBetween(0, 2),
                    "country" => $faker->country,
                    "province" => $faker->state,
                    "city" => $faker->phoneNumber,
                    "status" => 1
                ]
            );
            $wechat->save();

            for ($n = 0; $n < mt_rand(20, 99); $n++) {
                if ($cover >= 30) {
                    $cover = 0;
                }
                $video = new Video(
                    [
                        "title" => $faker->text,
                        "url" => $faker->imageUrl(),
                        "cover_url" => "/cover/" . ++$cover . ".jpg",
                        "file_id" => $faker->regexify('[1-9][0-9]{15}'),
                        "uploaded_at" => $faker->dateTime,
                        "classification_id" => $faker->numberBetween(10000, 99999),
                        "played_number" => $faker->numberBetween(10000, 99999),
                        "liked_number" => $faker->numberBetween(10000, 99999),
                        "shared_wechat_number" => $faker->numberBetween(10000, 99999),
                        "shared_moment_number" => $faker->numberBetween(10000, 99999),
                        "visibility" => 1,
                        "status" => 1
                    ]
                );
                $wechat->video()->save($video);
            }
        }

        foreach (Wechat::query()->get() as $wechat) {
            $wechat->followed()->saveMany(Wechat::query()->inRandomOrder()->take(mt_rand(5, 10))->get());
            $wechat->liked()->saveMany(Video::query()->inRandomOrder()->take(mt_rand(5, 10))->get());
        }

        $this->comment('Ok');
    }
}