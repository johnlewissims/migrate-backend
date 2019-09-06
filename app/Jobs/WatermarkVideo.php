<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Video;
use FFMpeg;

class WatermarkVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      FFMpeg::fromDisk('public')->open('videos/'. $this->video->id . '/' .$this->video->name)->getFrameFromSeconds(1)->export()->toDisk('public')->save('/videos/'. $this->video->id . '/' .'screenshot.png');

      FFMpeg::fromDisk('public')->open('videos/'. $this->video->id . '/' .$this->video->name)->addFilter(function ($filters) {
      $filters->watermark(storage_path('app/public/watermarks/nike-logo.png'), [
              'position' => 'relative',
              'bottom' => 50,
              'left' => 50,
          ]);
      })->export()->toDisk('public')->inFormat(new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))->save('/videos/'. $this->video->id . '/' . 'watermark.mov');
    }
}
