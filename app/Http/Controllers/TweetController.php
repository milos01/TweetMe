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

    public function findTweet(FindTweetRequest $request){
    	$tweetUrl = $request->tweet_url;
    	$tweetId = $this->getTweetId($tweetUrl);

    	$foundTweet = $this->ifTweetExists($tweetId);
    	if($foundTweet != null){
    		dd($foundTweet->tweet_id);
    	}else{
    		FetchTwitterDataJob::dispatch($tweetId, $this->userFollowersSum);
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


    private function ifTweetExists($tweetId){
    	return $this->findTweetById($tweetId);
    }
}
