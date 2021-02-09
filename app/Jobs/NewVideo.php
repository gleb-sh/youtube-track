<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\VideoService;

class NewVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;
    public $channel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($v_id,$c_id)
    {
        $this->video = $v_id;
        $this->channel = $c_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        VideoService::newByChannel($this->video,$this->channel);
    }
}
