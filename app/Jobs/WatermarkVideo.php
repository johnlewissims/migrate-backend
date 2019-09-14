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
      FFMpeg::fromDisk('local')->open('private/videos/'. $this->video->id . '/' .$this->video->name)->addFilter(function ($filters) {
      $filters->watermark(storage_path('app/public/watermarks/nike-logo.png'), [
              'position' => 'relative',
              'bottom' => 50,
              'left' => 50,
          ]);
      })->export()->toDisk('local')->inFormat(new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))->save('private/videos/'. $this->video->id . '/watermark.mov');

      FFMpeg::fromDisk('local')->open('private/videos/'. $this->video->id . '/watermark.mov')->getFrameFromSeconds(1)->export()->toDisk('public')->save('/videos/ZWSWB6MFGRtybP4p/'. $this->video->id .'/screenshot.png');
      Video::where('id', $this->video->id)->update(['status'=>'Uploaded']);
    }
}
