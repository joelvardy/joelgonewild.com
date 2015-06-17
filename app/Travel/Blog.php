<?php

/**
 * Blog library
 *
 * @author	Joel Vardy <info@joelvardy.com>
 */

namespace Travel;

use Sunra\PhpSimple\HtmlDomParser;

class Blog {


	/**
	 * Read categories and posts
	 *
	 * @return	array
	 */
	public static function data() {

		$categories = [];

        // Iterate through each category
		foreach (glob(POSTS_PATH.'/*') as $category_path) {

			$posts = [];

			$category_details = json_decode(file_get_contents($category_path.'/category.json'));

			$category = (object) [
				'slug' => pathinfo($category_path)['filename'],
				'title' => $category_details->title,
				'description' => $category_details->description,
				'date' => strtotime($category_details->date),
			];

            // Iterate through each post in the category
			foreach (glob($category_path.'/*') as $post_directory) {

				if ( ! is_dir($post_directory)) continue;

				$post_slug = pathinfo($post_directory)['filename'];

				$photos = [];

                // Iterate through each photo in the post
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

				$post_dom = HtmlDomParser::str_get_html($html);
				$paragraph1 = (string) $post_dom->find('p', 0);
				$paragraph2 = (string) $post_dom->find('p', 1);
				$introduction = $paragraph1.$paragraph2;

				$details = (object) [
					'slug' => $post_slug,
					'category' => $category,
					'title' => $post->title,
					'written' => strtotime($post->written),
					'description' => $post_dom->find('p', 0)->innertext,
					'introduction' => $introduction,
					'photos' => $photos,
					'html' => $html
				];

				if (isset($post->heroPhoto)) {
					$details->heroPhoto = $post->heroPhoto;
				}

				$posts[] = $details;

			}

			// Order posts by written date
			usort($posts, function ($a, $b) {
				return $b->written - $a->written;
			});

			$categories[$category->slug] = clone $category;
			$categories[$category->slug]->posts = $posts;

		}

        // Order $categories by date
        usort($categories, function ($a, $b) {
            return $b->date - $a->date;
        });

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
	 * Read single category
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

		return $posts;

	}


	/**
	 * Read single post
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
