<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class TwitterService{

	protected $guzzle;

	/**
     * Create a new service instance.
     *
     * @return void
     */
	public function __construct(){
		$this->guzzle = $this->twitterGuzzleClient();
	}

	/**
     * Get all user that retweeted specific tweet.
     *
     * @return Json response
     */
	public function getRetweetsIds($tweetId){
		try {
	    	$generatedUrl = $this->urlGenerator('statuses/retweeters/ids.json?id=', $tweetId, '&stringify_ids=true');
			$res = $this->guzzle->request('GET', $generatedUrl);
			$jsonResponse = json_decode($res->getBody());
			return $jsonResponse;
		} catch (ClientException $exception) {
		    return $exception->getResponse();
		}
	}

	/**
     * Get followers for specific user.
     *
     * @return Json repsonse
     */
	public function getUserFollowers($userId){
		$generatedUrl = $this->urlGenerator('users/show.json?user_id=', $userId);
		$res = $this->guzzle->request('GET', $generatedUrl);
		$jsonResponse = json_decode($res->getBody());
		return $jsonResponse;
	}

	/**
     * URL maker method.
     *
     * @return string
     */
	private function urlGenerator($base, $id, $meta = ""){
		return $base.$id.$meta;
	}

	/**
     * Creates Guzzle client for communication with Twitter API.
     *
     * @return Json repsonse
     */
	private function twitterGuzzleClient(){
		$stack = HandlerStack::create();

        $auth = new Oauth1([
            'consumer_key' => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
            'token' => env('TWITTER_ACCESS_TOKEN'),
            'token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET')
        ]);

        $stack->push($auth);

		$guzzle = new Client([
			'base_uri' => 'https://api.twitter.com/1.1/',
            'handler' => $stack,
            'auth' => 'oauth'
		]);

		return $guzzle;
	}
}