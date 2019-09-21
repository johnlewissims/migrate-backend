<?php

namespace App\Http\Controllers;
use App\Video;
use App\User;
use App\Watermark;
use Illuminate\Http\Request;
use Image;

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
    $privatePath = 'app/public/watermarks/'. $watermark->id. '/';

    //Move watermark file to new folder
    $fileName = $request->name;
    $request->file('file')->move(storage_path($privatePath), $fileName);

    //Resize watermark
    $thumbnailpath = storage_path($privatePath . '/' . $fileName);
    $img = Image::make($thumbnailpath)->resize(150, 150, function($constraint) {
        $constraint->aspectRatio();
    });
    $img->save($thumbnailpath);

    return response()->json(['response' => 'The watermark has been created.'], 200);
  }

  public function delete(Watermark $watermark) {
    $watermark->delete();
    return response()->json(['response' => 'The watermark has been deleted.'], 200);
  }
}
