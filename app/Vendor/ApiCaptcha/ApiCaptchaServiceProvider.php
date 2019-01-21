<?php

namespace App\Vendor\ApiCaptcha;

use Illuminate\Support\ServiceProvider;

class ApiCaptchaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['router']->get('/api/captcha/{captcha?}','\App\Vendor\ApiCaptcha\ApiCaptchaController@getCaptcha');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Merge configs
        /*$this->mergeConfigFrom(
            __DIR__.'/../config/captcha.php', 'captcha'
        );*/

        // Bind captcha
        $this->app->bind('apiCaptcha', function($app)
        {
            return new ApiCaptchaService(
                $app['Illuminate\Filesystem\Filesystem'],
                $app['Illuminate\Config\Repository'],
                $app['Intervention\Image\ImageManager'],
                $app['Illuminate\Session\Store'],
                $app['Illuminate\Hashing\BcryptHasher'],
                $app['Illuminate\Support\Str']
            );
        });
    }
}
