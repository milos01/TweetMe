<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SaveTweetCountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tweetId;

    protected $userFollowersSum;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tweetId, $userFollowersSum)
    {
        $this->tweetId = $tweetId;
        
        $this->userFollowersSum = $userFollowersSum;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TweetCount $tweetCount)
    {
        
    }
}
