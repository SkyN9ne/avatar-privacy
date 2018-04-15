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

namespace Avatar_Privacy\Default_Icons\Generator\Jdenticon\Shapes\Center;

use Avatar_Privacy\Default_Icons\Generator\Jdenticon\Context;
use Avatar_Privacy\Default_Icons\Generator\Jdenticon\Point;
use Avatar_Privacy\Default_Icons\Generator\Jdenticon\Shape;

/**
 * A center shape.
 */
class Negative_Square implements Shape {

	/**
	 * Render the shape in the given graphics context.
	 *
	 * @param  Context $graphics The drawing context.
	 * @param  int     $cell     The cell size.
	 * @param  int     $index    The current index.
	 */
	public function render( Context $graphics, $cell, $index ) {
		$inner = $cell * 0.14;
		$inner =
			// Small icon => anti-aliased border.
			$cell < 8 ? $inner :
			// Large icon => truncate decimals.
			(int) $inner;

		// Use fixed outer border widths in small icons to ensure the border is drawn.
		$outer =
			$cell < 4 ? 1 :
			$cell < 6 ? 2 :
			( (int) ( $cell * 0.35 ) );

		$graphics->add_rectangle( new Point( 0, 0 ), $cell, $cell );
		$graphics->add_rectangle( new Point( $outer, $outer ), $cell - $outer - $inner, $cell - $outer - $inner, true );
	}
}
