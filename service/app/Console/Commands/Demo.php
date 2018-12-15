<?php

namespace App\Console\Commands;

use App\Models\Classification;
use App\Models\FollowedWechat;
use App\Models\FollowerReport;
use App\Models\Log;
use App\Models\Video;
use App\Models\VideoReport;
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
        VideoReport::query()->truncate();
        FollowerReport::query()->truncate();
        Log::query()->truncate();
        Classification::query()->truncate();
        $this->comment('填充分类');
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
        $this->comment('Ok');
        $cover = 0;
        $avatar = 0;
        $faker = Faker::create('zh_CN');
        for ($i = 0; $i < 100; $i++) {
            if ($avatar >= 100) {
                $avatar = 0;
            }
            $this->comment('填充用户');
            $wechat = new Wechat(
                [
                    "open_id" => config('wechat.mini_program.default.app_id') . '|' . $faker->regexify('[0-9A-Z]{32}'),//18+1+42
                    "union_id" => null,
                    "avatar" => "https://www.xiangtu.net.cn/avatar/" . ++$avatar . '.jpg',
                    "nickname" => $faker->name,
                    "sex" => $faker->numberBetween(0, 2),
                    "country" => $faker->country,
                    "province" => $faker->state,
                    "city" => $faker->phoneNumber,
                    "status" => 1
                ]
            );
            $wechat->save();
            $this->comment($wechat->nickname.',Ok');

            $this->comment('填充视频');
            for ($n = 0; $n < mt_rand(20, 99); $n++) {
                if ($cover >= 30) {
                    $cover = 0;
                }
                $video = new Video(
                    [
                        "title" => $faker->text,
                        "url" => $faker->imageUrl(),
                        "cover_url" => "https://www.xiangtu.net.cn/avatar/cover/" . ++$cover . ".jpg",
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
                $this->comment($video->title.',Ok');
            }
        }

        foreach (Wechat::query()->get() as $wechat) {
            $this->comment('添加收藏');
            $many = $many = Wechat::query()->inRandomOrder()->take(mt_rand(5, 10))->get();
            foreach ($many as $item) {
                $wechat->followed()->save(new FollowedWechat([
                    'wechat_id' =>$item->id,
                    'followed_id'=>$wechat->id
                ]));
                Log::query()->create(
                    ['action' => '关注',
                        'from_user_id' => $wechat->id,
                        'to_user_id' => $item->id,
                        'video_id' => 0,
                        'message' => $wechat->nickname . '关注了' . $item->nickname
                    ]
                );
            }
            $this->comment('Ok');
            $this->comment('添加关注');
            $wechat->liked()->saveMany($many = Video::query()->inRandomOrder()->take(mt_rand(5, 10))->get());
            foreach ($many as $item) {
                Log::query()->create(
                    ['action' => '收藏',
                        'from_user_id' => $wechat->id,
                        'to_user_id' => 0,
                        'video_id' => $item->id,
                        'message' => $wechat->nickname . '收藏了一个视频'
                    ]
                );
            }
            $this->comment('Ok');
        }

        $this->comment('Ok');
    }
}