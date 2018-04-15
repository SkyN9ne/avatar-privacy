<?php
/**
 * This file is part of Avatar Privacy.
 *
 * Copyright 2018 Peter Putzer.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 *  ***
 *
 * @package mundschenk-at/avatar-privacy
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Avatar_Privacy\Default_Icons\Generator;

use Avatar_Privacy\Default_Icons\Generator\Jdenticon\Icon_Generator;
use Avatar_Privacy\Default_Icons\Generator\Jdenticon\SVG_Renderer;
use Avatar_Privacy\Default_Icons\Generator\Jdenticon\SVG_Writer;


/**
 * Generates an SVG icon based on a hash.
 *
 * This is a partial PHP port of Jdenticon by Daniel Mester Pirttijärvi
 * (https://github.com/aurora/identicon).
 *
 * @since 1.0.0
 *
 * @author Peter Putzer <github@mundschenk.at>
 */
class Jdenticon implements Generator {

	/**
	 * Builds an icon based on the given seed returns the image data.
	 *
	 * @param  string $seed The seed data (hash).
	 * @param  int    $size Optional. The size in pixels. Default 128 (but really ignored).
	 *
	 * @return string
	 */
	public function build( $seed, $size = 128 ) {
		$writer    = new SVG_Writer( $size );
		$generator = new Icon_Generator( new SVG_Renderer( $writer ), $seed, 0, 0, $size, 0 );

		return (string) $writer;
	}

}
