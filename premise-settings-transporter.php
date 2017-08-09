<?php
/**
 * Main plugin file.
 * Adds a settings Import/ Export feature to the "Premise" premium landing page
 *    & member access plugin.
 *
 * @package   Premise Settings Transporter
 * @author    David Decker
 * @copyright Copyright (c) 2013, David Decker - DECKERWEB
 * @link      http://deckerweb.de/twitter
 *
 * Plugin Name: Premise Settings Transporter
 * Plugin URI: http://genesisthemes.de/en/wp-plugins/premise-settings-transporter/
 * Description: Adds a Import/Export feature to the "Premise" premium landing page & member access plugin.
 * Version: 1.1.0
 * Author: David Decker - DECKERWEB
 * Author URI: http://deckerweb.de/
 * License: GPL-2.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 * Text Domain: premise-settings-transporter
 * Domain Path: /languages/
 *
 * Copyright (c) 2013 David Decker - DECKERWEB
 *
 *     This file is part of Premise Settings Transporter,
 *     a plugin for WordPress.
 *
 *     Premise Settings Transporter is free software:
 *     You can redistribute it and/or modify it under the terms of the
 *     GNU General Public License as published by the Free Software
 *     Foundation, either version 2 of the License, or (at your option)
 *     any later version.
 *
 *     Premise Settings Transporter is distributed in the hope that
 *     it will be useful, but WITHOUT ANY WARRANTY; without even the
 *     implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *     PURPOSE. See the GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with WordPress. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting constants.
 *
 * @since 1.0.0
 */
/** Plugin directory */
define( 'PRST_PLUGIN_DIR', dirname( __FILE__ ) );

/** Plugin base directory */
define( 'PRST_PLUGIN_BASEDIR', dirname( plugin_basename( __FILE__ ) ) );

/** Set constant/ filter for plugin's languages directory */
define(
	'PRST_LANG_DIR',
	apply_filters( 'prst_filter_lang_dir', PRST_PLUGIN_BASEDIR . '/languages/' )
);

/** Required Version of Genesis Framework */
define( 'PRST_REQUIRED_PREMISE', '2.1+' );


register_activation_hook( __FILE__, 'ddw_prst_activation' );
/**
 * Check the environment when plugin is activated.
 *   - Requirement: Premise plugin needs to be installed and activated.
 *   - Note: register_activation_hook() isn't run after auto or manual upgrade,
 *           only on activation!
 *
 * @since  1.0.0
 *
 * @uses   load_plugin_textdomain()
 * @uses   deactivate_plugins()
 * @uses   wp_die()
 *
 * @param  $prst_premise_deactivation_message
 *
 * @return string Optional plugin activation messages for the user.
 */
function ddw_prst_activation() {

	/** Load translations to display for the activation message. */
	load_plugin_textdomain( 'premise-settings-transporter', false, PRST_LANG_DIR );

	/** Check for activated "Premise" plugin - admin class */
	if ( ! class_exists( 'Premise_Admin_Boxes' ) ) {

		/** If no Premise, deactivate ourself */
		deactivate_plugins( plugin_basename( __FILE__ ) );

		/** Message: no Premise active */
		$prst_premise_deactivation_message = sprintf(
			__( 'Sorry, you cannot activate the %1$s plugin unless you have installed the latest version of the %2$sPremise Plugin%3$s (at least %4$s).', 'premise-settings-transporter' ),
			__( 'Premise Settings Transporter', 'premise-settings-transporter' ),
			'<a href="http://deckerweb.de/go/premise/" target="_new"><strong><em>',
			'</em></strong></a>',
			'<code>' . PRST_REQUIRED_PREMISE . '</code>'
		);

		/** Deactivation message */
		wp_die(
			$prst_premise_deactivation_message,
			__( 'Plugin', 'premise-settings-transporter' ) . ': ' . __( 'Premise Settings Transporter', 'premise-settings-transporter' ),
			array( 'back_link' => true )
		);

	}  // end-if Premise check

}  // end of function ddw_prst_activation


add_action( 'init', 'ddw_prst_init' );
/**
 * Load the textdomain for translation of the plugin.
 * Load admin helper functions - only within 'wp-admin'.
 *
 * @since 1.0.0
 *
 * @uses  is_admin()
 * @uses  load_textdomain()	To load translations first from WP_LANG_DIR sub folder.
 * @uses  load_plugin_textdomain() To additionally load default translations from plugin folder (default).
 *
 * @param string 	$prst_textdomain
 * @param string 	$plugin_locale
 * @param string 	$prst_wp_lang_dir
 */
function ddw_prst_init() {

	/** Include admin functions when needed */
	if ( is_admin() ) {

		/** Set unique textdomain string */
		$prst_textdomain = 'premise-settings-transporter';

		/** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
		$plugin_locale = apply_filters( 'plugin_locale', get_locale(), $prst_textdomain );

		/** Set filter for WordPress languages directory */
		$prst_wp_lang_dir = apply_filters(
			'prst_filter_wp_lang_dir',
			WP_LANG_DIR . '/premise-settings-transporter/' . $prst_textdomain . '-' . $plugin_locale . '.mo'
		);

		/** Translations: First, look in WordPress' "languages" folder = custom & update-secure! */
		load_textdomain( $prst_textdomain, $prst_wp_lang_dir );

		/** Translations: Secondly, look in plugin's "languages" folder = default */
		load_plugin_textdomain( $prst_textdomain, FALSE, PRST_LANG_DIR );


		/** Include file with admin extra stuff */
		require_once( PRST_PLUGIN_DIR . '/includes/prst-admin-extras.php' );
		require_once( PRST_PLUGIN_DIR . '/includes/prst-admin-functions.php' );

		/** Include file for third-party plugins support */
		require_once( PRST_PLUGIN_DIR . '/includes/prst-plugins-support.php' );

	}  // end-if is_admin() check

	/** Add "Settings" links to plugin page */
	if ( is_admin() && current_user_can( 'manage_options' ) ) {

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ) , 'ddw_prst_settings_page_link' );

	} // end-if is_admin() plus cap check

}  // end of function ddw_prst_init


add_action( 'premise_admin_init', 'ddw_prst_admin_init', 11 );
/**
 * Load plugin's admin settings page - only within 'wp-admin'.
 * 
 * @since 1.0.0
 *
 * @uses  is_admin()
 */
function ddw_prst_admin_init() {

	/** If in 'wp-admin' include admin settings & help tabs */
	if ( is_admin() ) {

		/** Load the settings & help stuff */
		require_once( PRST_PLUGIN_DIR . '/includes/prst-import-export.php' );

	}  // end-if is_admin() check

}  // end of function ddw_prst_admin_init


add_action( 'premise_admin_init', 'ddw_prst_settings_menu', 15 );
/**
 * Instantiate the class to create the menu.
 *
 * @since  1.0.0
 *
 * @global $prst_premise_import_export
 */
function ddw_prst_settings_menu() {

	global $prst_premise_import_export;

	$prst_premise_import_export = new DDW_Premise_Admin_Import_Export;

}  // end of function ddw_prst_settings_menu


/**
 * Returns current plugin's header data in a flexible way.
 *
 * @since  1.0.0
 *
 * @uses   get_plugins()
 * @uses   plugin_basename()
 *
 * @param  $prst_plugin_value
 * @param  $prst_plugin_folder
 * @param  $prst_plugin_file
 *
 * @return string Plugin data.
 */
function ddw_prst_plugin_get_data( $prst_plugin_value ) {

	/** Bail early if we are not in wp-admin */
	if ( ! is_admin() ) {
		return;
	}

	/** Include WordPress plugin data */
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	$prst_plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$prst_plugin_file = basename( ( __FILE__ ) );

	return $prst_plugin_folder[ $prst_plugin_file ][ $prst_plugin_value ];

}  // end of function ddw_prst_plugin_get_data