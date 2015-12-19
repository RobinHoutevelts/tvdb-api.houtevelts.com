<?php

get('/', function () {
    return view('welcome');
});

get('/show/{showId}', 'ApiController@getShowById');
get('/show/{showId}/episodes', 'ApiController@getShowEpisodes');
get('/show/{showId}/actors', 'ApiController@getShowActors');
get('/show/{showId}/banners', 'ApiController@getShowBanners');

get('/episode/{episodeId}', 'ApiController@getEpisode');
