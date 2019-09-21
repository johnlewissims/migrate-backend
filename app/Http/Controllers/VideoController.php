<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Video;
use App\Watermark;
use App\User;
use App\Jobs\WatermarkVideo;
use App\Http\Resources\Video as VideoResource;
use Illuminate\Http\Request;
use App\Http\Requests\VideoStoreRequest;
use App\Http\Requests\UpdateVideoRequest;
use FFMpeg;
use Response;
use File;

class VideoController extends Controller
{

    public function index(){
      $user = User::find(auth()->user()->id);
      $videos = $user->video()->orderBy('id','DESC')->paginate(5);
      return $videos;
    }

    public function show(Video $video){
      return new VideoResource($video);
    }

    public function view(Request $request, Video $video) {
      //$file = Storage::get('private/videos/'. $video->id. '/watermark.mov');
      $file = Storage::disk('local')->get('private/videos/'. $video->id. '/watermark.mov');
      $response = Response::make($file, 200);
      $response->header("Content-Type", "video/mp4");
      return $response;
    }

    public function store(Request $request) {
      $watermark = Watermark::where('id', $request->watermark_id)->get('name');
      $watermarkName = $watermark[0]['name'];
      //return $watermarkName

      if ($request->hasFile('file')) {

        //Make video record
        $video = Video::create([
          'name' => $request->filename,
          'owner_id' => $request->user_id,
          'watermark_id' => $request->watermark_id,
          'title' => $request->title,
          'description' => $request->description,
          'type' => $request->type,
          'size' => $request->size,
          'status' => 'Uploading',
        ]);

        //Attach Videos to Users
        $video->user()->attach($request->user_id);
        $video->user()->attach($request->selectedSponsor);

        //Make video folders
        $privatePath = 'app/private/videos/'. $video->id. '/';
        $privatePathTwo = 'private/videos/'. $video->id. '/';
        Storage::makeDirectory($privatePathTwo, 0775, true);

        //Move video file to new folder
        $fileName = $request->filename;
        $request->file('file')->move(storage_path($privatePath), $fileName);

        //Dispatch Watermarking
        $this->dispatch(new WatermarkVideo($video));

        return new VideoResource($video);

      } else {
        return response()->json(['response' => 'Please upload or record a video.'], 404);
      }
    }

    public function patch(UpdateVideoRequest $request, Video $video){
      $video->title = $request->get('title', $video->title);
      $video->description = $request->get('description', $video->description);
      if ($request->filename) {
        $privatePathTwo = 'private/videos/'. $video->id;
        Storage::deleteDirectory($privatePathTwo);
        Storage::makeDirectory($privatePathTwo, 0775, true);

        $video->name = $request->get('filename', $video->filename);
        $video->type = $request->get('type', $video->type);
        $video->size = $request->get('size', $video->size);
        $video->status = $request->get('status', 'Uploading');
        $video->watermark_id = $request->get('watermark_id', $video->watermark_id);

        //Attach Videos to Users
        $userVideo = Video::find($video->id);
        $userVideo->user()->detach();

        if($request->user_id) {
          $video->user()->attach($request->user_id);
          $video->user()->attach($request->selectedSponsor);
        }

        //Move video file to new folder
        $privatePath = 'app/private/videos/'. $video->id. '/';
        $fileName = $request->filename;
        $request->file('file')->move(storage_path($privatePath), $fileName);

        //Dispatch Watermarking
        $this->dispatch(new WatermarkVideo($video));

      }

      $video->save();
      return new VideoResource($video);
    }

    public function status(Request $request, Video $video) {
      $video->status = $request->get('status', $video->status);
      $video->save();
      return response()->json(['response' => 'Status has been updated.'], 200);
    }

    public function deleteVideo(Video $video) {
      $openPath = public_path('videos/ZWSWB6MFGRtybP4p/'. $video->id);
      Storage::deleteDirectory($openPath);
      $video->delete();
      return response()->json(['response' => 'The video has been deleted.'], 200);
    }

    //User Assignment to Videos
    public function assign(Request $request, Video $video) {
      $video->user()->attach($request->user_id);
      return response()->json(['response' => 'User has been assigned to video.'], 200);
    }

    public function list(Request $request, Video $video) {
      $videoRecord = Video::find($video->id);
      $users = $videoRecord->user()->get()->all();
      return $users;
    }

    public function delete(Request $request, Video $video) {
      $video->user()->detach($request->user_id);
      return response()->json(['response' => 'User has been removed from video.'], 200);
    }

    //List users
    public function users() {
      $users = User::all()->where('role', 'Sponsor');
      return $users;
    }

    public function user(User $user) {
      return $user;
    }

}
