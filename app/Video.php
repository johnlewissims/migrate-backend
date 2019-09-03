<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
  protected $fillable = [
      'name', 'title',  'type', 'extension', 'user_id'
  ];
  public function user()
  {
      return $this->belongsTo(User::class);
  }
}
