<?php

namespace App\Http\Controllers\Helpers;
use App\TweetCount;

trait TweetCountHelper {
	public function findTweetById($tweetId){
		$tweet = TweetCount::where('tweet_id', $tweetId)->first();
		return $tweet;
	}
}