<?php
/**
 * Admin functions, for hooking third-party plugins into the Premise Exporter.
 *
 * @package    Premise Settings Transporter
 * @subpackage Admin
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2013, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/premise-settings-transporter/
 * @link       http://deckerweb.de/twitter
 *
 * @since      1.0.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'prst_filter_premise_export_options', 'ddw_prst_add_plugins_support', 11, 1 );
/**
* Hook third-party plugins into the "Premise Exporter",
*    allowing those settings to be exported.
*
* @since  1.0.0
*
* @param  $prst_plugin_string
* @param  $prst_plugin_prefix
* @param  $prst_plugin_suffix_copyblogger
* @param  $prst_plugin_suffix_other
* @param  array $options Premise Exporter options.
*
* @return array
*/
function ddw_prst_add_plugins_support( array $options ) {

	/** Helper strings */
	$prst_plugin_string             = '*' . __( 'Third-party plugin', 'premise-settings-transporter' );
	$prst_plugin_prefix             = $prst_plugin_string . ': ';
	$prst_plugin_suffix_copyblogger = ' (' . __( 'official release', 'premise-settings-transporter' ) . ')';
	$prst_plugin_suffix_other       = ' (' . __( 'community release', 'premise-settings-transporter' ) . ')';

	define( 'PRST_PLUGIN_STRING', $prst_plugin_string );

	/** Plugin: WP Premise Box (free, by Jimmy Peña) */
	if ( /* defined( 'WPPB_DEFAULT_ENABLED' ) */ function_exists( 'wp_premise_box_options_init' ) ) {

		$options[ 'plgpremisebox' ] = array(
			'label'          => $prst_plugin_prefix . __( 'WP Premise Box', 'premise-settings-transporter' ) . $prst_plugin_suffix_other,
			'settings-field' => 'wp_premise_box'
		);

	}  // end-if

	/** Plugin: Premise Infusionsoft® Integration (premium, by Eugen Oprea) */
	if ( defined( 'MEMBER_ACCESS_SETTINGS_FIELD' ) && class_exists( 'PremiseInfusionSoft' ) ) {

		$options[ 'plgpremiseinfusion' ] = array(
			'label'          => $prst_plugin_prefix . __( 'Infusionsoft® Integration', 'premise-settings-transporter' ) . $prst_plugin_suffix_other,
			'settings-field' => 'premise-infusionsoft-settings'
		);

	}  // end-if

	/** Plugin: Premise iDevAffiliate Integration (free, by Eugen Oprea) */
	if ( defined( 'MEMBER_ACCESS_SETTINGS_FIELD' ) && class_exists( 'PremiseIDevAffiliate' ) ) {

		$options[ 'plgidevaff' ] = array(
			'label'          => $prst_plugin_prefix . __( 'Premise iDevAffiliate Integration', 'premise-settings-transporter' ) . $prst_plugin_suffix_other,
			'settings-field' => 'premise-idevaffiliate-settings'
		);

	}  // end-if

	/** Plugin: GA Ecommerce Tracking for Premise (free, by Eugen Oprea) */
	if ( defined( 'MEMBER_ACCESS_SETTINGS_FIELD' ) && class_exists( 'PremiseGAEcommerce_Admin_Boxes' ) ) {

		$options[ 'plggatracking' ] = array(
			'label'          => $prst_plugin_prefix . __( 'Premise GA Ecommerce Tracking', 'premise-settings-transporter' ) . $prst_plugin_suffix_other,
			'settings-field' => 'premise-ga-ecommerce-settings'
		);

	}  // end-if

	/**
	 * Return the additional "Premise" third-party extensions plugins settings
	 *    fields to hook into the Premise Exporter.
	 */
	return $options;

}  // end of function ddw_prst_add_plugins_support