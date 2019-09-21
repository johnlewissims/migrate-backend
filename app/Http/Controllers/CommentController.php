<?php

namespace App\Http\Controllers;
use App\Video;
use App\User;
use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
  public function showComments(Video $video){
    $video = Video::find($video->id);
    $comments = $video->comment()->orderBy('id','DESC')->get();
    return $comments;
  }

  public function postComment(Request $request, Video $video){
    $watermark = Comment::create([
      'video_id' => $video->id,
      'user_id' => $request->user_id,
      'comment' => $request->comment,
    ]);

    return response()->json(['response' => 'The comment has been added.'], 200);
  }

  public function deleteComment(Comment $comment){
    $comment->delete();
    return response()->json(['response' => 'The comment has been deleted.'], 200);
  }
}
