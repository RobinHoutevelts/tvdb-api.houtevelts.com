<?php

namespace App\Http\Controllers;

use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ResourceNotFoundException;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicSeries;
use CanIHaveSomeCoffee\TheTVDbAPI\TheTVDbAPI;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller {

  /** @var \Moinax\TvDb\Client */
  protected $tvDb;
  /** @var TheTVDbAPI */
  protected $tvDbV2;

  public function __construct()
  {
    $this->tvDb = app()->make('TvDb');
    $this->tvDbV2 = app()->make('TvDbV2');
  }

  public function getShowById($showId)
  {
    $show = $this->tvDb->getSerie($showId);
    return $show->jsonSerialize();
  }

  public function getShowBySlug($slug)
  {
    $slug = strtolower(trim($slug));

    $results = [];
    try {
        $results = $this->tvDbV2->search()->searchBySlug($slug);
    } catch (ResourceNotFoundException $e) {
        // noop
    }

    if (
      !$results
      || !is_array($results)
      || empty($results[0])
      || !$results[0] instanceof BasicSeries
      || $results[0]->slug !== $slug
    ) {
      return JsonResponse::create([], 404);
    }

    return $this->getShowById($results[0]->id);
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
