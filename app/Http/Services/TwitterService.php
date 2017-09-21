<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Support\Facades\Log;
// use App\Http\Controllers\Helpers\TwitterHelper;

class TwitterService{

	// use TwitterHelper;

	protected $guzzle;

	public function __construct(){
		$stack = HandlerStack::create();

        $auth = new Oauth1([
            'consumer_key' => 'q5S19rrikwVBVUcI6Vj59Fy2D',
            'consumer_secret' => 'UtSk7aawgbDK0SmXxdGaehCp8RgCLGZ0oZQPrPHrinF8UeTbbl',
            'token' => '379035310-LGYGliTjORTVZgMW8KadmeEhuRRwDDi4CuAcDFSC',
            'token_secret' => 'U204odi6c60GNhIQkcJikV3I5qiazrzHvO8wJgSmrcx5N'
        ]);

        $stack->push($auth);

		$this->guzzle = new Client([
			'base_uri' => 'https://api.twitter.com/1.1/',
            'handler' => $stack,
            'auth' => 'oauth'
		]);
	}

	public function getRetweetsIds($tweetId){
		
		return $this->retweetsIds($this->guzzle, $tweetId);
		
	}

	public function getUserFollowers($userId){
		return $this->userFollowers($this->guzzle, $userId);
	}

	function retweetsIds($guzzle, $tweetId){
		try {
	    	$generatedUrl = $this->urlGenerator('statuses/retweeters/ids.json?id=', $tweetId, '&stringify_ids=true');
			$res = $guzzle->request('GET', $generatedUrl);
			$jsonResponse = json_decode($res->getBody());
			return $jsonResponse;
		} catch (ClientException $exception) {
		    return $exception->getResponse();
		}
	}

	public function userFollowers($guzzle, $userId){
		$generatedUrl = $this->urlGenerator('users/show.json?user_id=', $userId);
		$res = $guzzle->request('GET', $generatedUrl);
		$jsonResponse = json_decode($res->getBody());
		return $jsonResponse;
	}

	private function urlGenerator($base, $id, $meta = ""){
		return $base.$id.$meta;
	}
}