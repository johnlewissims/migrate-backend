<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Watermark extends Model
{
  use Orderable;
  protected $fillable = [
    'user_id', 'name'
  ];
  public function user()
  {
      return $this->belongsTo(User::class);
  }
}
