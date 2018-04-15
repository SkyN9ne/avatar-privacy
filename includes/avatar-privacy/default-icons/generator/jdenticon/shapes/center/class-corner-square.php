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
class Corner_Square implements Shape {

	/**
	 * Render the shape in the given graphics context.
	 *
	 * @param  Context $graphics The drawing context.
	 * @param  int     $cell     The cell size.
	 * @param  int     $index    The current index.
	 */
	public function render( Context $graphics, $cell, $index ) {
		$inner = $cell * 0.1;
		$inner =
			// Large icon => truncate decimals.
			$inner > 1 ? ( (int) $inner ) :
			// Medium size icon => fixed width.
			$inner > 0.5 ? 1 :
			// Small icon => anti-aliased border.
			$inner;

		// Use fixed outer border widths in small icons to ensure the border is drawn.
		$outer =
			$cell < 6 ? 1 :
			$cell < 8 ? 2 :
			( (int) ( $cell * 0.25 ) );

		$graphics->add_rectangle( new Point( $outer, $outer ), $cell - $inner - $outer, $cell - $inner - $outer );
	}
}
