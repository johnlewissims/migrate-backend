<?php

namespace App\Policies;

use App\User;
use App\Video;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function index()
    {
      //return $user->ownsVideo($video);
    }

    public function update(User $user, Video $video)
    {
      return $user->ownsVideo($video);
    }

    public function destroy(User $user, Video $video)
    {
      return $user->ownsTopic($video);
    }
}
