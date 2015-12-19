<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller {

  /** @var \Moinax\TvDb\Client */
  protected $tvDb;

  public function __construct()
  {
    $this->tvDb = app()->make('TvDb');
  }

  public function getShowById($showId)
  {
    $show = $this->tvDb->getSerie($showId);
    return $show->jsonSerialize();
  }

  public function getShowEpisodes($showId)
  {
    $episodes = $this->tvDb->getSerieEpisodes($showId);

    return JsonResponse::create($episodes);
  }

  public function getShowActors($showId)
  {
    $actors = $this->tvDb->getActors($showId);

    return JsonResponse::create($actors);
  }

  public function getShowBanners($showId)
  {
    $banners = $this->tvDb->getBanners($showId);

    return JsonResponse::create($banners);
  }

  public function getEpisodeById($episodeId)
  {
    $episode = $this->tvDb->getEpisodeById($episodeId);

    return JsonResponse::create($episode);
  }
}
