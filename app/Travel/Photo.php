<?php

/**
 * Photo library
 *
 * @author	Joel Vardy <info@joelvardy.com>
 */

namespace Travel;

use Intervention\Image\ImageManagerStatic as Image;

class Photo {


	/**
	 * Resize a photo
	 *
	 * @return	boolean | string
	 */
	public static function resize($filepath, $size) {

		$resized_filepath = CACHE_PATH.'/'.$size.'-'.md5($filepath);

		if (file_exists($resized_filepath)) return $resized_filepath;

		$image = Image::make(POSTS_PATH.'/'.$filepath);
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
