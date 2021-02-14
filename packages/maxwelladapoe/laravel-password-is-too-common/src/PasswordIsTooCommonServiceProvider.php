<?php


namespace MaxwellAdapoe\PasswordIsTooCommon;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use MaxwellAdapoe\PasswordIsTooCommon\App\Models\CommonPassword;

class PasswordIsTooCommonServiceProvider extends ServiceProvider
{
    protected $defer = false;

    protected $message = 'The password entered is too common. Please provide another!';


    public function boot()
    {

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');
        $this->publishes([
            __DIR__.'/../database/seeders/' => database_path('seeders')
        ], 'seeders');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');



        Validator::extend('too_common', function ($attribute, $value, $parameters, $validator) {
            $path= realpath(__DIR__.'/../resources/common_password_list.txt');
            $commonPasswordList = file_get_contents($path);

            $cacheKeyName = md5(env('APP_NAME','password_list'));
            $data =Cache::rememberForever($cacheKeyName.'password_cache', function () use ($commonPasswordList) {
                return collect(explode(",",$commonPasswordList))->map(function ($password){
                    return strtolower($password);
                });
            });

            return !$data->contains(strtolower($value));

        }, $this->message);
    }


    public function register()
    {

    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */

    public function provides()
    {
        return ['laravel-password-is-too-common'];
    }
}
