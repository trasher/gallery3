<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2013 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */

class movie_resized_event_Core {
	static function movie_img ($movie_img, $obj) {
		$resize_file = $obj->resize_path().'.mp4';
		$relative_file = $obj->relative_path();
		$resize_url = $obj->resize_url(true);
		#print pretty_backtrace();

		if (file_exists($resize_file)) {
			// in case the resize is a different size
			list ($width, $height, $mime_type, $ext, $duration) = movie::get_file_metadata($resize_file);

			// copied this from modules/gallery/models/items.php
			$view = new View("movieplayer.html");
			$view->max_size = $movie_img->max_size;
			$view->width = $width ? $width : $movie_img->width;;
			$view->height = $height ? $height : $movie_img->height;;
			$view->attrs = $movie_img->attrs;
			$view->url = str_replace($relative_file, $relative_file.'.mp4', $resize_url);
			$view->fp_params = $movie_img->fp_params;
			$view->fp_config = $movie_img->fp_config;

			// add some scalling logic
			$view->width = $view->width/2;
			$view->height = $view->height/2;

			#$movie_img->view[] = $view->render();
			$movie_img->view[] = "<video src=\"{$view->url}\" width=\"{$view->width}\" height=\"{$view->height}\" controls style=\"max-width: 100%\"></video>";
		}
	}
}
