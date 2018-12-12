<?php

namespace App\Providers;

use App\Models\Classification;
use App\Models\User;
use App\Models\Wechat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            $view->with('user', $user);
            if ($user) {
                switch (get_class($user)) {
                    case Wechat::class:
                        $view->with('auth', 'wechat');
                        $view->with('Bearer', $user ? $user->createToken(request()->userAgent())->accessToken : null);
                        break;
                    case User::class:
                        $view->with('auth', 'user');
                        $view->with('Bearer', null);
                        break;
                    default:
                        $view->with('auth', 'guest');
                        break;
                }
            } else {
                $view->with('auth', 'guest');
            }
            $view->with('current_classification', request('classification'));
            $view->with('classifications', Classification::query()->take(15)->get());
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
