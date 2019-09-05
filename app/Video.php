<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
  protected $fillable = [
      'name', 'title', 'description',  'type', 'size', 'user_id'
  ];
  public function user()
  {
      return $this->belongsTo(User::class);
  }
}
