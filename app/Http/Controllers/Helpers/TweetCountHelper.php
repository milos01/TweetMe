<?php

namespace App\Http\Controllers\Helpers;
use App\TweetCount;
use Carbon\Carbon;

trait TweetCountHelper {
	public function findTweetById($tweetId){
		$tweet = TweetCount::where('tweet_id', $tweetId)->first();
		return $tweet;
	}

	public function checkAndUpdate($tweet){
		
		$length = $this->getDifference($tweet);
		if ($length < 0) {
			$tweet->delete();
		}
	}

	private function getDifference($tweet){
		$tweetCreatedTime = Carbon::parse($tweet->created_at)->addHours(2);
		$now = Carbon::now();

		return $now->diffInSeconds($tweetCreatedTime, false);
	}
}