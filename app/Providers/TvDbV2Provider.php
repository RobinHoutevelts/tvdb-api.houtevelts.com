<?php

namespace App\Providers;

use CanIHaveSomeCoffee\TheTVDbAPI\TheTVDbAPI;
use Illuminate\Support\ServiceProvider;

class TvDbV2Provider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind('TvDbV2', function () {
            $apiKey = env('TVDB_APIKEY', null);
            if (!$apiKey) {
                throw new \Exception('You need a TvDb API key.');
            }

            $theTVDbAPI = new TheTVDbAPI();
            $theTVDbAPI->setAcceptedLanguages(['nl', 'en']);
            $token = $theTVDbAPI->authentication()->login($apiKey);
            $theTVDbAPI->setToken($token);

            return $theTVDbAPI;
        });
    }
}
