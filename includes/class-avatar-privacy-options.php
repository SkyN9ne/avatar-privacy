<?php
/**
 * This file is part of Avatar Privacy.
 *
 * Copyright 2018 Peter Putzer.
 * Copyright 2012-2013 Johannes Freudendahl.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * version 2 as published by the Free Software Foundation.
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

/**
 * Options class of the Avatar Privacy plugin. Contains all code for the
 * options page. The plugin's options are displayed on the discussion settings
 * page.
 *
 * @author Johannes Freudendahl, wordpress@freudendahl.net
 */
class Avatar_Privacy_Options {

	/**
	 * The plugin core.
	 *
	 * @var Avatar_Privacy_Core
	 */
	private $core = null;

	/**
	 * Creates a Avatar_Privacy_Options instance and registers all necessary
	 * hooks and filters for the settings.
	 *
	 * @param object $core_instance An Avatar_Privacy_Core instance.
	 */
	public function __construct( $core_instance ) {
		$this->core = $core_instance;
		// Register the settings to be displayed.
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	/**
	 * Registers the settings with the settings API.
	 */
	public function register_settings() {
		// Add a section for the 'check for gravatar' mode to the avatar options.
		add_settings_section( 'avatar_privacy_section', __( 'Avatar Privacy', 'avatar-privacy' ) . '<span id="section_avatar_privacy"></span>', [ $this, 'output_settings_header' ], 'discussion' );
		add_settings_field( 'avatar_privacy_checkforgravatar', __( 'Check for gravatars', 'avatar-privacy' ),        [ $this, 'output_checkforgravatar_setting' ], 'discussion', 'avatar_privacy_section' );
		add_settings_field( 'avatar_privacy_optin',            __( 'Opt in or out of gravatars', 'avatar-privacy' ), [ $this, 'output_optin_setting' ],            'discussion', 'avatar_privacy_section' );
		add_settings_field( 'avatar_privacy_checkbox_default', __( 'The checkbox is...', 'avatar-privacy' ),         [ $this, 'output_checkbox_default_setting' ], 'discussion', 'avatar_privacy_section' );
		add_settings_field( 'avatar_privacy_default_show',     __( 'Default value', 'avatar-privacy' ),              [ $this, 'output_default_show_setting' ],     'discussion', 'avatar_privacy_section' );
		// We save all settings in one variable in the database table; also adds a validation method.
		register_setting( 'discussion', Avatar_Privacy_Core::SETTINGS_NAME, [ $this, 'validate_settings' ] );
	}

	/**
	 * Validates the plugin's settings, rejects any invalid data.
	 *
	 * @param array $input The array of settings values to save.
	 * @return array The cleaned-up array of user input.
	 */
	public function validate_settings( $input ) {
		// Validate the settings.
		$newinput['mode_checkforgravatar'] = ( isset( $input['mode_checkforgravatar'] ) && ( $input['mode_checkforgravatar'] === '1' ) ) ? '1' : '0';
		$newinput['mode_optin']            = ( isset( $input['mode_optin'] ) && ( $input['mode_optin'] === '1' ) ) ? '1' : '0';
		$newinput['checkbox_default']      = ( isset( $input['checkbox_default'] ) && ( $input['checkbox_default'] === '1' ) ) ? '1' : '0';
		$newinput['default_show']          = ( isset( $input['default_show'] ) && ( $input['default_show'] === '1' ) ) ? '1' : '0';
		// Check if the headers function works on the server (use MD5 of mystery default image).
		if ( $newinput['mode_checkforgravatar'] == '1' ) {
			$uri     = 'http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=32&d=404';
			$headers = @get_headers( $uri );
			if ( ! is_array( $headers ) ) {
				add_settings_error(
				  Avatar_Privacy_Core::SETTINGS_NAME, 'get-headers-failed',
					__(
					'The get_headers() function seems to be disabled on your system! To check if a gravatar exists for an E-Mail address,'
					  . ' this PHP function is needed. It seems this function is either disabled on your system or the gravatar.com'
					  . " servers can not be reached for another reason. Check with your server admin if you don't see gravatars for your own"
					  . ' gravatar account and this message keeps popping up after saving the plugin settings.', 'avatar-privacy'
					),
					'error'
			  );
			}
		}

		return $newinput;
	}

	/**
	 * Outputs the header of the Avatar Privacy settings section.
	 */
	public function output_settings_header() {
		require dirname( __DIR__ ) . '/admin/partials/sections/avatars-enabled.php';
	}

	/**
	 * Outputs the elements for the 'check for gravatar' setting.
	 */
	public function output_checkforgravatar_setting() {
		$options = get_option( Avatar_Privacy_Core::SETTINGS_NAME );
		if ( ( $options === false ) || ! isset( $options['mode_checkforgravatar'] ) ) {
			$options['mode_checkforgravatar'] = false;
		}

		require dirname( __DIR__ ) . '/admin/partials/settings/check-for-gravatar.php';
	}

	/**
	 * Outputs the elements for the 'optin' setting.
	 */
	public function output_optin_setting() {
		$options = get_option( Avatar_Privacy_Core::SETTINGS_NAME );
		if ( ( $options === false ) || ! isset( $options['mode_optin'] ) ) {
			$options['mode_optin'] = false;
		}

		require dirname( __DIR__ ) . '/admin/partials/settings/optin.php';
	}

	/**
	 * Outputs the elements for the 'checkbox default' setting.
	 */
	public function output_checkbox_default_setting() {
		$options = get_option( Avatar_Privacy_Core::SETTINGS_NAME );
		if ( ( $options === false ) || ! isset( $options['checkbox_default'] ) ) {
			$options['checkbox_default'] = false;
		}

		require dirname( __DIR__ ) . '/admin/partials/settings/checkbox-default.php';
	}

	/**
	 * Outputs the elements for the 'default show' setting.
	 */
	public function output_default_show_setting() {
		$options = get_option( Avatar_Privacy_Core::SETTINGS_NAME );
		if ( ( $options === false ) || ! isset( $options['default_show'] ) ) {
			$options['default_show'] = false;
		}

		require dirname( __DIR__ ) . '/admin/partials/settings/default-show.php';
	}
}