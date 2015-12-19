<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Moinax\TvDb\Client;
use Moinax\TvDb\Http\Cache\FilesystemCache;
use Moinax\TvDb\Http\CacheClient;

class TvDbProvider extends ServiceProvider {

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
    app()->bind('TvDb', function () {
      $apiKey = env('TVDB_APIKEY', null);
      if (!$apiKey)
        throw new \Exception('You need a TvDb API key.');

      $cache      = new FilesystemCache(storage_path() . '/TvDbCache');
      $ttl        = 60 * 60 * 24;
      $httpClient = new CacheClient($cache, $ttl);

      $tvdb = new Client("http://thetvdb.com", $apiKey);
      $tvdb->setHttpClient($httpClient);
      $tvdb->setJsonDateFormat('d-m-Y');
      $tvdb->setDefaultLanguage('nl');

      return $tvdb;
    });
  }
}
