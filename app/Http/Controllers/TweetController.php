<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FindTweetRequest;
use App\Jobs\FetchTwitterDataJob;
use App\Jobs\SaveTweetCountJob;
use App\Http\Controllers\Helpers\TweetCountHelper;
use App\TweetCount;

class TweetController extends Controller
{

	use TweetCountHelper;

	private $twitterService;
	private $userFollowersSum;
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->userFollowersSum = 0;
    }

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function findTweet(FindTweetRequest $request){
    	$tweetUrl = $request->tweet_url;
    	$tweetId = $this->getTweetId($tweetUrl);

    	$foundTweet = $this->ifTweetExists($tweetId);
    	if ($foundTweet == null) {
    		FetchTwitterDataJob::dispatch($tweetId, $this->userFollowersSum);
    	}else{
    		$needToUpdate = $this->checkForUpdate($foundTweet);
	    	if($needToUpdate){
	    		$this->deleteTweet($foundTweet);
	    		FetchTwitterDataJob::dispatch($tweetId, $this->userFollowersSum);
	    	}
    	}

    	return back();
    }

    /**
     * Get id from tweet url.
     *
     * @return string
     */
    private function getTweetId($tweetUrl){
    	$urlMap = parse_url($tweetUrl);
    	$urlPathPieces = explode("/", $urlMap["path"]);
    	return end($urlPathPieces);
    }

    /**
     * Check if the tweet needs to be updated in database.
     *
     * @return void
     */
    private function checkForUpdate($tweet){
    	// $tweet = $this->findTweetById($tweetId);
    	return $this->checkAndUpdate($tweet);
    }

	/**
     * Check if the tweet exists database.
     *
     * @return \Illuminate\Http\Response
     */
    private function ifTweetExists($tweetId){
    	$foundTweet = $this->findTweetById($tweetId);

    	return $foundTweet;
    }
}
