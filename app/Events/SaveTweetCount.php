<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\TweetCount;

class SaveTweetCount
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tweetCount;
    public $tweetId;
    public $userFollowersSum;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TweetCount $tweetCount, $tweetId, $userFollowersSum){
        $this->tweetCount = $tweetCount;
        $this->tweetId = $tweetId;
        $this->userFollowersSum = $userFollowersSum;
    }
}
