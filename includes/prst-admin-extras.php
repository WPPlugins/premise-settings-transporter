<?php
/**
 * Helper functions for the admin - plugin links and help tabs.
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


/**
 * Setting internal plugin helper links constants.
 *
 * @since 1.0.0
 *
 * @uses  get_locale()
 */
define( 'PRST_URL_TRANSLATE',		'http://translate.wpautobahn.com/projects/genesis-plugins-deckerweb/premise-settings-transporter' );
define( 'PRST_URL_WPORG_FAQ',		'http://wordpress.org/plugins/premise-settings-transporter/faq/' );
define( 'PRST_URL_WPORG_FORUM',		'http://wordpress.org/support/plugin/premise-settings-transporter' );
define( 'PRST_URL_WPORG_PROFILE',	'http://profiles.wordpress.org/daveshine/' );
define( 'PRST_URL_FORUM', 			esc_url( PRST_URL_WPORG_FORUM ) );
define( 'PRST_PLUGIN_LICENSE', 		'GPL-2.0+' );
if ( get_locale() == 'de_DE' || get_locale() == 'de_AT' || get_locale() == 'de_CH' || get_locale() == 'de_LU' ) {
	define( 'PRST_URL_DONATE', 		'http://genesisthemes.de/spenden/' );
	define( 'PRST_URL_PLUGIN',		'http://genesisthemes.de/plugins/premise-settings-transporter/' );
} else {
	define( 'PRST_URL_DONATE', 		'http://genesisthemes.de/en/donate/' );
	define( 'PRST_URL_PLUGIN',		'http://genesisthemes.de/en/wp-plugins/premise-settings-transporter/' );
}


/**
 * Add "Widgets Page" link to plugin page.
 *
 * @since  1.0.0
 *
 * @param  $prst_links
 * @param  $prst_settings_link
 *
 * @return strings Widgets & Pages admin links.
 */
function ddw_prst_settings_page_link( $prst_links ) {

	/** Settings (Export/ Import) Admin link */
	$prst_settings_link = sprintf(
		'<a href="%s" title="%s">%s</a>',
		admin_url( 'admin.php?page=premise-import-export' ),
		__( 'Go to the Premise Import/Export page', 'premise-settings-transporter' ),
		__( 'Import/Export', 'premise-settings-transporter' )
	);

	/** Set the order of the links */
	array_unshift( $prst_links, $prst_settings_link );

	/** Display plugin settings links */
	return apply_filters( 'prst_filter_settings_page_link', $prst_links );

}  // end of function ddw_prst_widgets_page_link


add_filter( 'plugin_row_meta', 'ddw_prst_plugin_links', 10, 2 );
/**
 * Add various support links to plugin page.
 *
 * @since  1.0.0
 *
 * @param  $prst_links
 * @param  $prst_file
 *
 * @return strings plugin links
 */
function ddw_prst_plugin_links( $prst_links, $prst_file ) {

	/** Capability check */
	if ( ! current_user_can( 'install_plugins' ) ) {

		return $prst_links;

	}  // end-if cap check

	/** List additional links only for this plugin */
	if ( $prst_file == PRST_PLUGIN_BASEDIR . '/premise-settings-transporter.php' ) {

		$prst_links[] = '<a href="' . esc_url( PRST_URL_WPORG_FAQ ) . '" target="_new" title="' . __( 'FAQ', 'premise-settings-transporter' ) . '">' . __( 'FAQ', 'premise-settings-transporter' ) . '</a>';

		$prst_links[] = '<a href="' . esc_url( PRST_URL_WPORG_FORUM ) . '" target="_new" title="' . __( 'Support', 'premise-settings-transporter' ) . '">' . __( 'Support', 'premise-settings-transporter' ) . '</a>';

		$prst_links[] = '<a href="' . esc_url( PRST_URL_TRANSLATE ) . '" target="_new" title="' . __( 'Translations', 'premise-settings-transporter' ) . '">' . __( 'Translations', 'premise-settings-transporter' ) . '</a>';

		$prst_links[] = '<a href="' . esc_url( PRST_URL_DONATE ) . '" target="_new" title="' . __( 'Donate', 'premise-settings-transporter' ) . '"><strong>' . __( 'Donate', 'premise-settings-transporter' ) . '</strong></a>';

	}  // end-if plugin links

	/** Output the links */
	return apply_filters( 'prst_filter_plugin_links', $prst_links );

}  // end of function ddw_prst_plugin_links


add_action( 'admin_init', 'ddw_prst_load_help', 16 );
/**
 * Load plugin help tab on plugin's admin page.
 *
 * @since  1.0.0
 *
 * @global mixed $prst_premise_import_export
 */
function ddw_prst_load_help() {

	global $prst_premise_import_export;

	add_action( 'load-' . $prst_premise_import_export->pagehook, 'ddw_prst_help_tab' );

}  // end of function ddw_xotb_edd_load_help


/**
 * Create and display plugin help tab.
 *
 * @since  1.0.0
 *
 * @uses   get_current_screen()
 * @uses   WP_Screen::add_help_tab()
 * @uses   WP_Screen::set_help_sidebar()
 * @uses   ddw_prst_help_sidebar_content()
 *
 * @global mixed $prst_exporter_screen
 */
function ddw_prst_help_tab() {

	global $prst_exporter_screen;

	$prst_exporter_screen = get_current_screen();

	/** Display help tabs only for WordPress 3.3 or higher */
	if ( ! class_exists( 'WP_Screen' )
		|| ! $prst_exporter_screen
	) {
		return;
	}

	/** Add general info & "Usage" help tab */
	$prst_exporter_screen->add_help_tab( array(
		'id'       => 'prst-import-export-help',
		'title'    => __( 'Premise Settings Transporter', 'premise-settings-transporter' ),
		'callback' => apply_filters( 'prst_filter_help_tab_usage', 'ddw_prst_help_tab_usage' ),
	) );

	/** Add "FAQ" help tab */
	$prst_exporter_screen->add_help_tab( array(
		'id'       => 'prst-faq-help',
		'title'    => __( 'FAQ', 'premise-settings-transporter' ),
		'callback' => apply_filters( 'prst_filter_help_tab_faq', 'ddw_prst_help_tab_faq' ),
	) );

	/** Add "Import & Backup Advise" help tab */
	$prst_exporter_screen->add_help_tab( array(
		'id'       => 'prst-import-backup-help',
		'title'    => __( 'Import & Backup Advise', 'premise-settings-transporter' ),
		'callback' => apply_filters( 'prst_filter_help_tab_import_backup', 'ddw_prst_help_tab_import_backup' ),
	) );

	/** Add help sidebar */
	$prst_exporter_screen->set_help_sidebar( ddw_prst_help_sidebar_content() );

}  // end of function ddw_prst_help_tab


/**
 * Create and display plugin's first help tab, plus content.
 *
 * @since 1.0.0
 *
 * @uses  ddw_prst_plugin_get_data() To display various data of this plugin.
 * @uses  ddw_prst_plugin_help_content_faq() To display FAQ help content.
 *
 * @param string 	$prst_json
 */
function ddw_prst_help_tab_usage() {

	/** Helper variable */
	$prst_json = 'title="JavaScript Object Notation" style="cursor: help;"';

	/** Help content */
	echo '<h3>' . __( 'Plugin', 'premise-settings-transporter' ) . ': ' . __( 'Premise Settings Transporter', 'premise-settings-transporter' ) . ' <small>v' . esc_attr( ddw_prst_plugin_get_data( 'Version' ) ) . '</small></h3>';

	echo '<h4><em>' . __( 'A Typical Workflow Example', 'premise-settings-transporter' ) . '</em></h4>' .
		'<p><em>' . __( 'Transfer settings from a development install to the live/ production install.', 'premise-settings-transporter' ) . '</em></p>' .
		'<p><strong>' . __( 'Prerequisites/ Requirements', 'premise-settings-transporter' ) . ':</strong></p>' .
		'<ul>' .
			'<li>' . sprintf( __( 'On BOTH sites/ installations you have installed & activated %s.', 'premise-settings-transporter' ), '&raquo;' . __( 'Premise', 'premise-settings-transporter' ) . '&laquo;' ) . '</li>' .
			'<li>' . sprintf( __( 'On BOTH sites/ installations you have installed & activated this plugin, %s.', 'premise-settings-transporter' ), '&raquo;' . __( 'Premise Settings Transporter', 'premise-settings-transporter' ) . '&laquo;' ) . '</li>' .
			'<li>' . __( 'It\'s recommended to have THE VERY SAME VERSIONS installed on the original site and also the receiving site. Reason: sometimes settings differ between plugin versions. So with making sure you have the same versions installed you just ensure the correct settings are included within the export file.', 'premise-settings-transporter' ) . '</li>' .
			'</ul>' .
		'<p><strong>' . __( 'Transfer', 'premise-settings-transporter' ) . ':</strong></p>' .
		'<ul>' .
			'<li>' . sprintf( __( 'On the development install: Just make an Export file via %s admin page:', 'premise-settings-transporter' ), '&raquo;' . __( 'Premise &#x2192; Import/ Export', 'premise-settings-transporter' ) . '&laquo;' ) . '</li>' .
			'<li>' . sprintf( __( 'In the %s section there enable all checkboxes you need.', 'premise-settings-transporter' ), '&raquo;' . __( 'Export', 'premise-settings-transporter' ) . '&laquo;' ) . '</li>' .
			'<li>' . sprintf( __( 'Save the %s file to your computer.', 'premise-settings-transporter' ), '<abbr ' . $prst_json . '><code>.json</code> (JSON)</abbr>' ) . '</li>' .
			'<li>' . sprintf( __( 'On the live/ production site, just import this %s file and you\'re done!', 'premise-settings-transporter' ), '<abbr ' . $prst_json . '><code>.json</code> (JSON)</abbr>' ) . ' ;-)</li>' .
		'</ul>';

	echo '<hr class="div" />';  // Genesis CSS class

	echo '<p><strong>' . __( 'Important plugin links:', 'premise-settings-transporter' ) . '</strong>' . 
		'<br /><a href="' . esc_url( PRST_URL_PLUGIN ) . '" target="_new" title="' . __( 'Plugin website', 'premise-settings-transporter' ) . '">' . __( 'Plugin website', 'premise-settings-transporter' ) . '</a> | <a href="' . esc_url( PRST_URL_WPORG_FAQ ) . '" target="_new" title="' . __( 'FAQ', 'premise-settings-transporter' ) . '">' . __( 'FAQ', 'premise-settings-transporter' ) . '</a> | <a href="' . esc_url( PRST_URL_WPORG_FORUM ) . '" target="_new" title="' . __( 'Support', 'premise-settings-transporter' ) . '">' . __( 'Support', 'premise-settings-transporter' ) . '</a> | <a href="' . esc_url( PRST_URL_TRANSLATE ) . '" target="_new" title="' . __( 'Translations', 'premise-settings-transporter' ) . '">' . __( 'Translations', 'premise-settings-transporter' ) . '</a> | <a href="' . esc_url( PRST_URL_DONATE ) . '" target="_new" title="' . __( 'Donate', 'premise-settings-transporter' ) . '"><strong>' . __( 'Donate', 'premise-settings-transporter' ) . '</strong></a></p>';

	echo '<p><a href="http://www.opensource.org/licenses/gpl-license.php" target="_new" title="' . esc_attr( PRST_PLUGIN_LICENSE ). '">' . esc_attr( PRST_PLUGIN_LICENSE ). '</a> &copy; ' . date( 'Y' ) . ' <a href="' . esc_url( ddw_prst_plugin_get_data( 'AuthorURI' ) ) . '" target="_new" title="' . esc_attr__( ddw_prst_plugin_get_data( 'Author' ) ) . '">' . esc_attr__( ddw_prst_plugin_get_data( 'Author' ) ) . '</a></p>';

}  // end of function ddw_prst_help_tab_usage


/**
 * Create and display plugin's "FAQ" help tab.
 *
 * @since 1.0.0
 *
 * @uses  ddw_prst_plugin_help_content_faq() To display FAQ help content.
 */
function ddw_prst_help_tab_faq() {

	echo '<h3>' . __( 'Premise Settings Transporter', 'premise-settings-transporter' ) . ': ' . __( 'FAQ', 'premise-settings-transporter' ) . '</h3>';

	echo ddw_prst_plugin_help_content_faq();

}  // end of function ddw_prst_help_tab_faq


/**
 * Create and display plugin's "Import & Backup Advise" help tab.
 *
 * @since 1.0.0
 *
 * @uses  ddw_prst_plugin_help_content_backup() To display Import & Backup help content.
 *
 * @param string 	$prst_json
 */
function ddw_prst_help_tab_import_backup() {

	/** Helper variable */
	$prst_json = 'title="JavaScript Object Notation" style="cursor: help;"';

	/** Help content */
	echo '<h3>' . __( 'Premise Settings Transporter', 'premise-settings-transporter' ) . ': ' . __( 'Import & Backup Advise', 'premise-settings-transporter' ) . '</h3>';

	echo ddw_prst_plugin_help_content_backup();

	echo '<p><strong>' . __( 'Import file formats', 'premise-settings-transporter' ) . ':</strong>' .
			'<blockquote><ul>' .
				'<li>' . sprintf( __( 'The below importer tool uses the %s file format.', 'premise-settings-transporter' ), '<abbr ' . $prst_json . '><code>.json</code> (JSON)</abbr>' ) . '</li>' .
				'<li>' . sprintf( __( 'The built-in importer tool for single Designs uses the %s file format.', 'premise-settings-transporter' ), '<code>.dat</code> (DAT)' ) . '</li>' .
				'<li><em>' . __( 'Just be careful to not mix them up', 'premise-settings-transporter' ) . ' ... :)</em></li>' .
			'</blockquote></ul></p>';

	echo '<p><strong>' . __( 'Backup strategy', 'premise-settings-transporter' ) . ':</strong>' .
			'<blockquote><ul>' .
				'<li>' . __( 'Making backups is always recommended, especially if you are doing imports of (many) Design Sets and/ or Button sets.', 'premise-settings-transporter' ) . '</li>' .
				'<li>' . __( 'Any kind of backups can be helpful', 'premise-settings-transporter' ) . ':' .
					'<br />&raquo; ' . __( 'Using the below exporter tool to make export files of <em>settings</em>.', 'premise-settings-transporter' ) .
					'<br />&raquo; ' . __( 'Using the WordPress exporter tool to make export files of Premise Landing Pages and/ or MemberAccess post types.', 'premise-settings-transporter' ) .
					'<br />&raquo; ' . __( 'Using full-featured backup plugins for WordPress to make database and file (think media library...) backups, that are also prepared for restoration or migration.', 'premise-settings-transporter' ) . '</li>' .
				'<li>' . __( 'Recommended - full-featured - backup solutions are (both premium)', 'premise-settings-transporter' ) . ':' .
					'<br />&raquo; <a href="http://ddwb.me/8f" target="_new">' . __( 'Snapshot (by WPMU DEV)', 'premise-settings-transporter' ) . '</a>' .
					'<br />&raquo; <a href="http://ddwb.me/38" target="_new">' . __( 'BackupBuddy (by iThemes)', 'premise-settings-transporter' ) . '</a></li>' .
			'</blockquote></ul></p>';

}  // end of function ddw_prst_help_tab_import_backup


/**
 * Create and display plugin help tab content for "FAQ" part.
 *
 * @since  1.0.0
 *
 * @param  $prst_string_design_settings
 * @param  $prst_faq_content_design_setting
 * @param  $prst_count_lp_published
 * @param  $prst_count_lp_draft
 * @param  $prst_count_lp_future
 * @param  $prst_count_lp_pending
 * @param  $prst_count_lp_private
 * @param  $prst_count_landing_pages
 * @param  $prst_string_lp
 * @param  $prst_string_lp_single
 * @param  $prst_string_xml
 * @param  $prst_create_lp
 *
 * @return string HTML help content FAQ.
 */
function ddw_prst_plugin_help_content_faq() {

	/** Helper string */
	$prst_string_design_settings = '<em>' . __( 'Desgin Settings', 'premise-settings-transporter' ) . '</em>';

	/** Part I: Design Settings FAQ */
	$prst_faq_content_design_setting = '<p><strong>' . sprintf( __( 'Why are the <em>individual</em> %1$s not included?', 'premise-settings-transporter' ), $prst_string_design_settings ) . '</strong><blockquote>' . sprintf( __( 'No worries, the <em>individual</em> %1$s have a built-in export/ import feature in Premise already! If you have already created more than one Design just can open each one and export/ import it individually. You can export all single %2$s except the default one. To export the default Design just duplicate it and then it also becomes exportable ;-).', 'premise-settings-transporter' ), $prst_string_design_settings, '<a href="' . admin_url( 'admin.php?page=premise-styles' ) . '">' . __( 'Designs', 'premise-settings-transporter' ) . '</a>' ) . '</blockquote></p>';

	/** Premise Landing Pages counter (only published, draft, future, pending, private) */
	$prst_count_lp_published  = wp_count_posts( 'landing_page' )->publish;
	$prst_count_lp_draft      = wp_count_posts( 'landing_page' )->draft;
	$prst_count_lp_future     = wp_count_posts( 'landing_page' )->future;
	$prst_count_lp_pending    = wp_count_posts( 'landing_page' )->pending;
	$prst_count_lp_private    = wp_count_posts( 'landing_page' )->private;
	$prst_count_landing_pages = $prst_count_lp_published + $prst_count_lp_draft + $prst_count_lp_future + $prst_count_lp_pending + $prst_count_lp_private;

	/** Only if Premise Landing Pages exist */
	if ( post_type_exists( 'landing_page' ) ) {

		/** Helper strings */
		$prst_string_lp = '<em>' . __( 'Landing Pages', 'premise-settings-transporter' ) . '</em>';
		$prst_string_lp_single = '<em>' . _n( 'Landing Page', 'Landing Pages', $prst_count_landing_pages, 'premise-settings-transporter' ) . '</em>';
		$prst_string_xml = '<code>.xml</code>';

		/** If there are no landing pages yet, invite to create one :) */
		if ( 1 <= $prst_count_landing_pages ) {

			$prst_create_lp = '';

		} else {

			$prst_create_lp = sprintf(
				'<br /><strong>&rarr;</strong> <a href="' . admin_url( 'post-new.php?post_type=landing_page' ) . '">%1$s</a>',
				sprintf( __( 'Why not create your first %1$s?', 'premise-settings-transporter' ), '<em>' . __( 'Landing Page', 'premise-settings-transporter' ) . '</em>' )
			);

		}  // end-if counter check

		/** Part II: Landings Pages FAQ */
		$prst_faq_content_landing_pages = '<p><strong>' . sprintf( __( 'Why are the %1$s not included?', 'premise-settings-transporter' ), $prst_string_lp ) . '</strong>' .
			'<blockquote><ul><li>' . sprintf( __( 'No worries, the Premise %1$s are a custom post type and therefore they could be exported/ imported via WordPress\' own export functionality for custom post types. Just go to %2$s select %1$s from the list there and make an %3$s export file for your landing pages only.', 'premise-settings-transporter' ), $prst_string_lp, '<a href="' . admin_url( 'export.php' ) . '"><em>' . __( 'Tools &#x2192; Export Data', 'premise-settings-transporter' ) . '</em></a>', $prst_string_xml ) . '</li>' .
				'<li>' . sprintf( __( 'To import the %1$s %2$s file, just install and activate the official %3$s plugin, then go to %4$s and upload your export file.', 'premise-settings-transporter' ), $prst_string_lp, $prst_string_xml, '<a href="http://wordpress.org/plugins/wordpress-importer/"><em>' . __( 'WordPress Importer', 'premise-settings-transporter' ) . '</em></a>', '<a href="' . admin_url( 'import.php' ) . '"><em>' . __( 'Tools &#x2192; Import Data', 'premise-settings-transporter' ) . '</em></a>' ) . '</li>' .
				'<li>' . sprintf( __( 'Currently, you have %1$s %2$s (including published, draft, scheduled, pending and private statuses).', 'premise-settings-transporter' ), '<strong>' . $prst_count_landing_pages . '</strong>', '<a href="' . admin_url( 'edit.php?post_type=landing_page' ) . '">' . $prst_string_lp_single . '</a>' ) . $prst_create_lp . '</li>' .
			'</ul></blockquote></p>';

	}  // end-if post type check

	/** Output the FAQ help content */
	return apply_filters( 'prst_filter_help_faq_content', $prst_faq_content_design_setting . $prst_faq_content_landing_pages );

}  // end of function ddw_prst_plugin_help_content_faq


/**
 * Create and display plugin help tab content for "Backup Advise" part.
 *
 * @since  1.0.0
 *
 * @param  $prst_faq_content_backup
 *
 * @return string HTML help content Backup Advise.
 */
function ddw_prst_plugin_help_content_backup() {

	$prst_faq_content_backup = '<div class="premise-option-box"><b>' . __( 'Please Note', 'premise-settings-transporter' ) . ':</b> ' . __( 'If you are importing a file containing a full set of Design Settings and/ or Button configurations, be aware that all Designs and Buttons with the same ID will be overridden! Don\'t complain about losing your data. You\'ve been warned.', 'premise-settings-transporter' ) . '</div>';

	/** Output the Backup Advise help content */
	return apply_filters( 'prst_filter_help_backup_content', $prst_faq_content_backup );

}  // end of function ddw_prst_plugin_help_content_backup


/**
 * Helper function for returning the Help Sidebar content.
 *
 * @since  1.0.0
 *
 * @uses   ddw_prst_plugin_get_data()
 *
 * @param  $prst_help_sidebar_content_extra
 * @param  $prst_help_sidebar_content
 *
 * @return string HTML content for help sidebar.
 */
function ddw_prst_help_sidebar_content() {

	$prst_help_sidebar_content_extra = '<p><strong>' . __( 'Actions', 'premise-settings-transporter' ) . '</strong></p>' .
		'<p>&rarr; <a href="' . esc_url( PRST_URL_FORUM ) . '" target="_new">' . __( 'Support Forum', 'premise-settings-transporter' ) . '</a></p>' .
		'<p style="margin-top: -5px; margin-bottom: 20px;">&rarr; <a href="' . esc_url( PRST_URL_DONATE ) . '" target="_new">' . __( 'Donate', 'premise-settings-transporter' ) . '</a></p>';

	$prst_help_sidebar_content = '<p><strong>' . __( 'More about the plugin author', 'premise-settings-transporter' ) . '</strong></p>' .
			'<p>' . __( 'Social:', 'premise-settings-transporter' ) . '<br /><a href="http://twitter.com/deckerweb" target="_blank" title="@ Twitter">Twitter</a> | <a href="http://www.facebook.com/deckerweb.service" target="_blank" title="@ Facebook">Facebook</a> | <a href="http://deckerweb.de/gplus" target="_blank" title="@ Google+">Google+</a> | <a href="' . esc_url( ddw_prst_plugin_get_data( 'AuthorURI' ) ) . '" target="_blank" title="@ deckerweb.de">deckerweb</a></p>' .
			'<p><a href="' . esc_url( PRST_URL_WPORG_PROFILE ) . '" target="_blank" title="@ WordPress.org">@ WordPress.org</a></p>';

	return apply_filters( 'prst_filter_help_sidebar_content', $prst_help_sidebar_content_extra . $prst_help_sidebar_content );

}  // end of function ddw_prst_help_sidebar_content