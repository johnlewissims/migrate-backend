<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function store(Request $request) {
      if ($request->hasFile('file')) {
        $fileName = $request->filename;
        $path = $request->file('file')->move(public_path("/"), $fileName);
        $photoUrl = url('/'.$fileName);
        $video = Video::create([
          'name' => $request->filename,
          'user_id' => $request->user_id,
          'title' => $request->title,
        ]);
        return response()->json(['url' => $photoUrl], 200);
      }
    }
}
