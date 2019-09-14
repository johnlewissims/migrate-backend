<?php

namespace App\Observers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Controllers\Controller;
use App\Jobs\WatermarkVideo;
use Storage;
use App\Video;
use FFMpeg;


class VideoObserver
{
    public function created(Video $video)
    {
      //WatermarkVideo::dispatch($video);
      //$this->dispatch(new WatermarkVideo($video));
    }

    public function updated(Video $video)
    {
        //
    }

    public function deleted(Video $video)
    {
        //
    }

    public function restored(Video $video)
    {
        //
    }

    public function forceDeleted(Video $video)
    {
        //
    }
}
