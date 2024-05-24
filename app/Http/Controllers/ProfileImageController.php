<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileImageController extends Controller
{
    public $profile_image_path = 'public/';
    public $profile_image_storage_path = 'storage/';

    public function formProfileImageStore($request, $input, $type = '')
    {
        $image = $request->file("profile_image");
        $this->profile_image_path = $type ? $this->profile_image_path . $type . '/profile_image/' :
            $this->profile_image_path . 'profile_image/';
        $image_name = time() . rand(1000000, 9999999) .  "." . $image->getClientOriginalExtension();
        $result = $image->storeAs($this->profile_image_path, $image_name);
        if ($result) {
            $input['profile_image'] = $image_name;
        }
        return $input;
    }

    public function formProfileImageUpdate($request, $model, $type)
    {
        $image = $request->file("profile_image");
        $this->profile_image_path = $this->profile_image_path . $type . '/profile_image/';
        $image_name = time() . rand(10000, 99999) .  "." . $image->getClientOriginalExtension();
        $result = $image->storeAs($this->profile_image_path, $image_name);
        if ($result) {
            if (Storage::exists($this->profile_image_path . $model->profile_image)) {
                Log::info('Form: File exists.');
                Storage::delete($this->profile_image_path .  $model->profile_image);
            } else {
                Log::info('Form: File does not exists.');
            }
            $model->profile_image = $image_name;
        }
        return $model;
    }
}
