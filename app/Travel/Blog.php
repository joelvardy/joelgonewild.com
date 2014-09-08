<?php

/**
 * Blog library
 *
 * @author	Joel Vardy <info@joelvardy.com>
 */

namespace Travel;

class Blog {


	/**
	 * Read posts
	 *
	 * @return	array
	 */
	public static function read() {

		$categories = [];

		foreach (glob(POSTS_PATH.'/*') as $category) {

			$posts = [];

			foreach (glob($category.'/*') as $post_directory) {

				if ( ! is_dir($post_directory)) continue;

				$photos = [];

				foreach (glob($post_directory.'/photos/*.jpg') as $photo) {
					$photos[] = pathinfo($photo)['filename'];
				}

				$post = (object) [];

				ob_start();
				require($post_directory.'/post.php');
				ob_get_clean();

				$posts[pathinfo($post_directory)['filename']] = (object) [
					'slug' => pathinfo($post_directory)['filename'],
					'title' => $post->title,
					'written' => strtotime($post->written),
					'photos' => $photos
				];

			}

			$category_details = json_decode(file_get_contents($category.'/category.json'));

			$categories[pathinfo($category)['filename']] = (object) [
				'slug' => pathinfo($category)['filename'],
				'title' => $category_details->title,
				'description' => $category_details->description,
				'posts' => $posts
			];

		}

		return $categories;

	}


}
