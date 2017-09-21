<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Services\TwitterService;
use App\Events\SaveTweetCount;
use App\TweetCount;
use App\Notifications\FetchTwitterDataFail;
use Notification;

class FetchTwitterDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tweetId;
    protected $userFollowersSum;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tweetId, $userFollowersSum){
        $this->tweetId = $tweetId;
        $this->userFollowersSum = $userFollowersSum;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TwitterService $twitterService, TweetCount $tweetCount)
    {   

        $tweet = $twitterService->getRetweetsIds($this->tweetId);
        foreach ($tweet->ids as $userId) {
            $user = $twitterService->getUserFollowers($userId);
            $this->userFollowersSum += $user->followers_count;
        }

        event(new SaveTweetCount(new TweetCount, $this->tweetId, $this->userFollowersSum));
        
    }

    // /**
    //  * The job failed to process.
    //  *
    //  * @param  Exception  $exception
    //  * @return void
    //  */
    // public function failed(Exception $exception)
    // {
    //     // Notification::send(TweetCount::first(), new FetchTwitterDataFail());
    // }
}
