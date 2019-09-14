<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoStoreRequest extends FormRequest
{
  public function authorize()
  {
      return true;
  }

  public function rules()
  {
      return [
        'title' => 'required',
        'owner_id' => 'owner_id',
        'description' => 'required',
      ];
  }
}
