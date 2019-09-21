<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Video extends Model
{
  use Orderable;
  protected $fillable = [
      'name', 'title', 'description',  'type', 'size', 'owner_id', 'status', 'watermark_id'
  ];
  public function user()
  {
      return $this->belongsToMany(User::class);
  }
  public function comment()
  {
      return $this->hasMany(Comment::class);
  }
}
