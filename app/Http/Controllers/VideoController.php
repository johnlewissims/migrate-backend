<?php

namespace App\Http\Controllers;

use Storage;
use App\Video;
use Illuminate\Http\Request;
use App\Http\Requests\VideoStoreRequest;
use FFMpeg;

class VideoController extends Controller
{
    public function store(Request $request) {
      if ($request->hasFile('file')) {

        //Make video record
        $video = Video::create([
          'name' => $request->filename,
          'user_id' => $request->user_id,
          'title' => $request->title,
          'description' => $request->description,
          'type' => $request->type,
          'size' => $request->size,
        ]);

        //Make video folder
        // $path = 'public/videos/'. $video->id;
        $openPath = 'app/public/videos/'. $video->id. '/';
        // Storage::makeDirectory($path);

        //Move video file to new folder
        $fileName = $request->filename;
        $request->file('file')->move(storage_path($openPath), $fileName);
        $photoUrl = url($openPath);

        //Create Screenshot from Video
        FFMpeg::fromDisk('public')->open('videos/'. $video->id . '/' .$request->filename)->getFrameFromSeconds(1)->export()->toDisk('public')->save('/videos/'. $video->id . '/' .'screenshot.png');

        //watermark Video
        FFMpeg::fromDisk('public')->open('videos/'. $video->id . '/' .$request->filename)->addFilter(function ($filters) {
        $filters->watermark(storage_path('app/public/watermarks/nike-logo.png'), [
                'position' => 'relative',
                'bottom' => 50,
                'left' => 50,
            ]);
        })->export()->toDisk('public')->inFormat(new \FFMpeg\Format\Video\X264)->save('/videos/'. $video->id . '/' . 'watermark.mov');

        //Response
        return response()->json(['url' => '$photoUrl'], 200);
      }
    }
}
