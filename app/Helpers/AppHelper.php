<?php

namespace App\Helpers;

use Intervention\Image\ImageManagerStatic as Image;

abstract class AppHelper {
    public static function uploadImage($request)
    {
        // Create new Filename to store
        $filename = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $request->file('file')->getClientOriginalExtension();
        $filenameToStore = $filename . '_' . time() . '.' . $extension;

        // Resize and store the new file
        $image_resize = Image::make($request->file('file')->getRealPath());
        $image_resize->resize(320, 240);
        $image_resize->save('storage/images/' . $filenameToStore);

        return $filenameToStore;
    }
}

