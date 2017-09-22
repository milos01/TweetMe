<?php

namespace App\Http\Controllers\Helpers;
use App\TweetCount;
use Carbon\Carbon;

trait TweetCountHelper {

	/**
     * Finds tweet in database.
     *
     * @return \Illuminate\Http\Response
     */
	public function findTweetById($tweetId){
		$tweet = TweetCount::where('tweet_id', $tweetId)->first();
		return $tweet;
	}

	/**
     * Checks if tweet need to be updated after 2 hours.
     *
     * @return boolean
     */
	public function checkAndUpdate($tweet){
		
		$length = $this->getDifference($tweet);
		if ($length < 0) {
			return true;
		}else{
			return false;
		}
	}

	/**
     * Deletes specific tweet.
     *
     * @return void
     */
	public function deleteTweet($tweet){
		
		$tweet->delete();
	}



	/**
     * Calculates differecne between 2 dates.
     *
     * @return integer
     */
	private function getDifference($tweet){
		$tweetCreatedTime = Carbon::parse($tweet->created_at)->addHours(2);
		$now = Carbon::now();

		return $now->diffInSeconds($tweetCreatedTime, false);
	}
}