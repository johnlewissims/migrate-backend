<?php

namespace App\Http\Controllers;
use App\Video;
use App\User;
use App\Watermark;
use Illuminate\Http\Request;

class WatermarkController extends Controller
{
  public function show($user){
    $watermarks = User::find($user)->watermark;
    return $watermarks;
  }

  public function store(Request $request){
    $watermark = Watermark::create([
      'name' => $request->name,
      'user_id' => $request->user_id,
    ]);

    //Make watermark folder
    $privatePath = 'app/private/videos/'. $video->id. '/';
  }

  public function delete(Watermark $watermark) {
    $watermark->delete();
    return response()->json(['response' => 'The watermark has been deleted.'], 200);
  }
}
