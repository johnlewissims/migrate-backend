<?php

namespace App\Http\Controllers;

use Storage;
use App\Video;
use App\Jobs\WatermarkVideo;
use App\Http\Resources\Video as VideoResource;
use Illuminate\Http\Request;
use App\Http\Requests\VideoStoreRequest;
use FFMpeg;

class VideoController extends Controller
{

    public function index(){
      //$this->authorize('index');
      $videos = Video::latestFirst()->paginate(10);
      return VideoResource::collection($videos);
    }

    public function store(Request $request) {
      if ($request->hasFile('file')) {

        //Make video record
        $video = Video::create([
          'name' => $request->filename,
          'title' => $request->title,
          'description' => $request->description,
          'type' => $request->type,
          'size' => $request->size,
        ]);

        $video->user()->attach($request->user_id);

        //Make video folder
        // $path = 'public/videos/'. $video->id;
        $openPath = 'app/public/videos/'. $video->id. '/';
        // Storage::makeDirectory($path);

        //Move video file to new folder
        $fileName = $request->filename;
        $request->file('file')->move(storage_path($openPath), $fileName);
        //$photoUrl = url($openPath);

        //Push Video to Watermark Job

        //Response
        $this->dispatch(new WatermarkVideo($video));
        return response()->json(['url' => '$photoUrl'], 200);
      }
    }
}
