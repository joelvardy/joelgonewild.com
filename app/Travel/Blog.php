<?php

/**
 * Blog library
 *
 * @author	Joel Vardy <info@joelvardy.com>
 */

namespace Travel;

class Blog {


	/**
	 * Read categories and posts
	 *
	 * @return	array
	 */
	public static function data() {

		$categories = [];

		foreach (glob(POSTS_PATH.'/*') as $category_path) {

			$posts = [];

			$category_details = json_decode(file_get_contents($category_path.'/category.json'));

			$category = (object) [
				'slug' => pathinfo($category_path)['filename'],
				'title' => $category_details->title,
				'description' => $category_details->description,
			];

			foreach (glob($category_path.'/*') as $post_directory) {

				if ( ! is_dir($post_directory)) continue;

				$post_slug = pathinfo($post_directory)['filename'];

				$photos = [];

				foreach (glob($post_directory.'/photos/*.jpg') as $photo) {
					$photo_slug = pathinfo($photo)['filename'];
					$photos[$photo_slug] = (object) [
						'slug' => $photo_slug,
						'path' => $category->slug.'/'.$post_slug.'/photos/'.pathinfo($photo)['basename']
					];
				}

				$post = (object) [];

				ob_start();
				require($post_directory.'/post.php');
				$html = ob_get_clean();

				$details = (object) [
					'slug' => $post_slug,
					'category' => $category,
					'title' => $post->title,
					'written' => strtotime($post->written),
					'photos' => $photos,
					'html' => $html
				];

				if (isset($post->heroPhoto)) {
					$details->heroPhoto = $post->heroPhoto;
				}

				$posts[pathinfo($post_directory)['filename']] = $details;

			}

			$categories[$category->slug] = clone $category;
			$categories[$category->slug]->posts = $posts;

		}

		return $categories;

	}


	/**
	 * Read categories
	 *
	 * @return	array
	 */
	public static function categories() {

		$data = self::data();

		$categories = [];

		foreach ($data as $category) {

			$categories[] = (object) [
				'slug' => $category->slug,
				'title' => $category->title,
				'description' => $category->description
			];

		}

		return $categories;

	}


	/**
	 * Read category
	 *
	 * @return	object | boolean
	 */
	public static function category($category_slug) {

		$data = self::data();

		foreach ($data as $category) {

			if ($category->slug === $category_slug) return $category;

		}

		return false;

	}


	/**
	 * Read posts
	 *
	 * @return	array
	 */
	public static function posts($category_slug = false) {

		$data = self::data();

		$posts = [];

		foreach ($data as $category) {
			foreach ($category->posts as $post) {

				if ($category_slug && $category->slug !== $category_slug) continue;

				$posts[] = $post;

			}
		}

		// Order posts by written date
		usort($posts, function ($a, $b) {
			return $a->written - $b->written;
		});
		sort($posts);

		return $posts;

	}


	/**
	 * Read posts
	 *
	 * @return	object | boolean
	 */
	public static function post($category_slug, $post_slug) {

		$data = self::data();

		foreach ($data as $category) {
			foreach ($category->posts as $post) {

				if ($category->slug === $category_slug && $post->slug === $post_slug) {
					return $post;
				}

			}
		}

		return false;

	}


}
