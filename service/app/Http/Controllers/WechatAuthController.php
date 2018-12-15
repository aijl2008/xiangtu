<?php

namespace App\Http\Controllers;

use App\Models\Wechat;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Overtrue\Socialite\AuthorizeFailedException;

class WechatAuthController extends Controller
{

    public function showLoginForm()
    {
        return view('login')->with('rows',Wechat::query()->has('video')->inRandomOrder()->take(12)->get());
    }

    public function redirect()
    {
        return $this->oauth()->redirect();
    }

    /**
     * @return \Overtrue\Socialite\Providers\WeChatProvider
     */
    private function oauth()
    {
        $config = [
            'app_id' => config("wechat.open_platform.default.app_id"),
            'secret' => config("wechat.open_platform.default.secret"),
            'oauth' => [
                'scopes' => config("wechat.open_platform.default.oauth.scopes"),
                'callback' => config("wechat.open_platform.default.oauth.callback") . urlencode(route('wechat.login.do'))
            ]
        ];
        $app = Factory::officialAccount($config);
        return $app->oauth;
    }

    public function mock(Request $request, $id){
        $wechat = Wechat::query()->findOrFail($id);
        Auth::guard('wechat')->login($wechat);
        return redirect()->to(route("my.videos.index"));
    }

    public function callback(Request $request)
    {
        try {
            $wechat = $this->oauth()->user()->getOriginal();
            if (!array_key_exists('openid', $wechat)) {
                abort(505, '微信接口返回的值中找不到openid');
            }
            $user = Wechat::query()->where('union_id', $wechat['unionid'] ?: $wechat['openid'])->first();
            if (!$user) {
                $user = new Wechat();
                $user->open_id = config('wechat.open_platform.default.app_id') . '|' . $wechat['openid'];
                $user->union_id = $wechat['unionid'];
                $user->nickname = $wechat['nickname'];
                $user->sex = $wechat['sex'];
                $user->province = $wechat['province'];
                $user->city = $wechat['city'];
                $user->country = $wechat['country'];
                $user->avatar = $wechat['headimgurl'];
                $user->save();
            }
            Auth::guard('wechat')->login($user);
            return redirect()->intended(route("my.videos.index"));
        } catch (AuthorizeFailedException $e) {
            abort(403, "认证已过期");
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('wechat')->logout();
        $request->session()->invalidate();
        return redirect()->to(route('wechat.login.show'));
    }
}