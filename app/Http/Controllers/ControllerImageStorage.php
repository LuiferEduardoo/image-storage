<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImageValidationRequest;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class ControllerImageStorage extends Controller
{
    public function createImage(ImageValidationRequest $request, $folder){
        if($request->file('image')){
            $file = $request->file('image');
            $path = public_path('img/' . $folder);
            $filename = $file->getClientOriginalName();
            // Cambiar el formato de la imagen
            $image = Image::load($file)
            ->format(Manipulations::FORMAT_WEBP)
            ->save($path . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.webp',80);
            $url = asset('img/' . $folder . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.webp');
            return response()->json([
                'message' => 'Image uploaded successfully',
                'url' => $url
            ], 200);
        }
        return response()->json([
            'message' => 'Invalid file'
        ], 400);
    }
}
