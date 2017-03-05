<?php

namespace Travel;

use Intervention\Image\ImageManagerStatic as Image;

class Photo
{


    public static function resize($filepath, $size)
    {

        $resized_filepath = CACHE_PATH . '/' . $size . '-' . md5_file(POSTS_PATH . '/' . $filepath);

        if (file_exists($resized_filepath)) {
            return $resized_filepath;
        }

        $image = Image::make(POSTS_PATH . '/' . $filepath);
        if ($image->width() > $image->height()) {
            $image->widen($size, function ($constraint) {
                $constraint->upsize();
            });
        } else {
            $image->heighten($size, function ($constraint) {
                $constraint->upsize();
            });
        }
        $image->save($resized_filepath);

        return $resized_filepath;

    }


}
