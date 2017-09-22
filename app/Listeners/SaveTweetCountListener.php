<?php

namespace App\Listeners;

use App\Events\SaveTweetCount;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\TweetCount;

class SaveTweetCountListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle SaveTweetCount the event.
     *
     * @param  SaveTweetCount  $event
     * @return void
     */
    public function handle(SaveTweetCount $event)
    {
        $event->tweetCount::create([
            'tweet_id' => $event->tweetId,
            'follower_sum' => $event->userFollowersSum,
        ]);
    }
}
