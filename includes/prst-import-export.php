<?php
/**
 * Adds Import & Export functionality for the "Premise" plugin.
 *
 * Based on the Import/ Export class of the Genesis Framework
 *    (by StudioPress, license: GPL-2.0+).
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
 * Registers a new admin page, providing content and corresponding menu item
 *    for the "Import/ Export" page.
 *
 * @since 1.0.0
 */
class DDW_Premise_Admin_Import_Export extends Premise_Admin_Basic {

	/**
	 * Create an admin menu item and settings page.
	 *
	 * Also hooks in the handling of file imports and exports.
	 *
	 * @since 1.0.0
	 *
	 * @uses  Premise_Admin::create() Register the admin page
	 *
	 * @see   DDW_Premise_Admin_Import_Export::export() Handle settings file exports
	 * @see   DDW_Premise_Admin_Import_Export::import() Handle settings file imports
	 */
	public function __construct() {

		/** Set a unique settings page ID */
		$page_id = 'premise-import-export';

		/** Set it as a submenu to 'Premise Main', and define the menu and page titles */
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'premise-main',
				'page_title'  => __( 'Premise - Import/ Export Settings', 'premise-settings-transporter' ),
				'menu_title'  => __( 'Import/ Export', 'premise-settings-transporter' )
			)
		);

		/** Set up admin page */
		$this->create( $page_id, $menu_ops );

		/** Add export & import methods */
		add_action( 'admin_init', array( $this, 'export' ) );
		add_action( 'admin_init', array( $this, 'import' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_css_js' ) );

	}  // end of method __construct


	/**
	 * Enqueue "Premise" admin CSS styles - only as helper styles.
	 *
	 * @since 1.0.0
	 *
	 * @uses  accesspress_is_menu_page()
	 * @uses  wp_enqueue_style()
	 * @uses  PREMISE_RESOURCES_URL
	 */
	function enqueue_admin_css_js() {
	
		/** Check we're on our own Import / Export page */
		if ( ! accesspress_is_menu_page( 'premise-import-export' ) ) {
			return;
		}

		/** Enqueue original Premise admin CSS */
		wp_enqueue_style(
			'premise-admin',
			PREMISE_RESOURCES_URL . 'premise-admin.css',
			array(),
			PREMISE_VERSION
		);

		/** Enqueue our own JavaScript enhancement */
		wp_enqueue_script(
			'prst-admin',
			plugins_url( 'js/prst-toggle.min.js', dirname( __FILE__ ) ),
			array( 'jquery' ),
			esc_attr( ddw_prst_plugin_get_data( 'Version' ) ),
			false
		);

	}  // end of method enqueue_admin_css_js


	/**
	 * Callback for displaying the Premise Import/ Export admin page.
	 *
	 * Echoes out HTML.
	 *
	 * Calls the 'prst_premise_import_export_form' action after the last default
	 *    table row.
	 *
	 * @since 1.0.0
	 *
	 * @uses  get_admin_page_title()
	 * @uses  menu_page_url()
	 * @uses  DDW_Premise_Admin_Import_Export::export_checkboxes() Echo export checkboxes
	 * @uses  DDW_Premise_Admin_Import_Export::get_export_options() Get array of export options
	 * @uses  ddw_prst_plugin_help_content_backup() To display Import Advise help content.
	 *
	 * @param string 	$prst_json
	 */
	public function admin() {

		/** Helper variable */
		$prst_json = 'title="JavaScript Object Notation" style="cursor: help;"';

		/** Begin form code */
		?>

		<div class="wrap">
			<?php screen_icon( 'tools' ); ?>
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

			<table class="form-table">
				<tbody>

					<tr>
						<th scope="row">
							<b><?php _e( 'Import Premise Settings File', 'premise-settings-transporter' ); ?></b>
						</th>
						<td>
							<p>
								<?php echo sprintf( __( 'Upload the data file (%s) from your computer and we\'ll import your settings.', 'premise-settings-transporter' ), '<abbr ' . $prst_json . '><code>.json</code> JSON</abbr>' ); ?>
							</p>
							<p>
								<?php _e( 'Choose the file from your computer and click "Upload file and Import"', 'premise-settings-transporter' ); ?>
							</p>
							<p>
								<form enctype="multipart/form-data" method="post" action="<?php echo menu_page_url( 'premise-import-export', 0 ); ?>">
									<?php wp_nonce_field( 'premise-import' ); ?>
									<input type="hidden" name="premise-import" value="1" />
									<label for="premise-import-upload"><?php sprintf( __( 'Upload File: (Maximum Size: %s)', 'premise-settings-transporter' ), ini_get( 'post_max_size' ) ); ?></label>
									<input type="file" id="premise-import-upload" name="premise-import-upload" size="25" />
									<?php
									submit_button( '&rarr; ' . __( 'Upload File and Import', 'premise-settings-transporter' ), 'primary', 'upload', false );
									?>
								</form>
							</p>
							<p>
								<?php echo ddw_prst_plugin_help_content_backup(); ?>
							</p>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<b><?php _e( 'Export Premise Settings File', 'premise-settings-transporter' ); ?></b>
						</th>
						<td>
							<p>
								<?php echo sprintf(
									__( 'When you click the button below, the %s plugin will generate a data file (%s) for you to save to your computer.', 'premise-settings-transporter' ),
									__( 'Premise Settings Transporter', 'premise-settings-transporter' ),
									'<abbr ' . $prst_json . '><code>.json</code> JSON</abbr>'
								); ?>
							</p>
							<p>
								<?php _e( 'Once you have saved the download file, you can use the import function on another - Premise empowered - site to import this data.', 'premise-settings-transporter' ); ?>
							</p>

							<p>
								<label for="selectall" class="button"><input type="checkbox" id="selectall" value="selectallbutton" style="display: none;" />&rarr; <?php _e( 'Select / Unselect ALL Checkboxes:', 'premise-settings-transporter' ); ?></label>
							</p>
							<p>
								<form method="post" action="<?php echo menu_page_url( 'premise-import-export', 0 ); ?>">

									<?php
									wp_nonce_field( 'premise-export' );
									$this->export_checkboxes();
									if ( $this->get_export_options() )
										submit_button( '&rarr; ' . __( 'Download Export File', 'premise-settings-transporter' ), 'primary', 'download' );
									?>
								</form>
							</p>
						</td>
					</tr>

					<?php do_action( 'prst_premise_import_export_form' ); ?>

				</tbody>
			</table>

		</div>

		<?php
		/** ^End form code */

	}  // end of method admin


	/**
	 * Add custom notices that display when you successfully import or export the settings.
	 *
	 * @since  1.0.0
	 *
	 * @uses   accesspress_is_menu_page() Check if we're on a "Premise"/ "AccessPress" page
	 *
	 * @return null Returns null if not on the correct admin page.
	 */
	public function notices() {

		/** Check we're on our own Import / Export page */
		if ( ! accesspress_is_menu_page( 'premise-import-export' ) ) {
			return;
		}

		if ( isset( $_REQUEST[ 'imported' ] ) && 'true' == $_REQUEST[ 'imported' ] ) {

			echo '<div id="message" class="updated"><p><strong>' . __( 'Settings successfully imported.', 'premise-settings-transporter' ) . '</strong></p></div>';

		} elseif ( isset( $_REQUEST[ 'error' ] ) && 'true' == $_REQUEST[ 'error' ] ) {

			echo '<div id="message" class="error"><p><strong>' . __( 'There was a problem importing your settings. Please try again.', 'premise-settings-transporter' ) . '</strong></p></div>';

		}

	}  // end of method notices


	/**
	 * Return array of export options and their arguments.
	 *
	 * Plugins (and even themes) can hook into the
	 *    'prst_filter_premise_export_options' filter to add their own settings
	 *    to the exporter.
	 *
	 * @since  1.0.0
	 *
	 * @return array Export options
	 */
	protected function get_export_options() {

		/** Include Premise main plugin settings */
		$options[ 'premise' ] = array(
				'label'          => __( 'Premise Main Settings', 'premise-settings-transporter' ),
				'settings-field' => PREMISE_SETTINGS_FIELD,
		);

		/** (ALL) Designs configuration settings (combined!) */
		$options[ 'desgins' ] = array(
				'label'          => __( 'Premise all Configured Designs/ Themes', 'premise-settings-transporter' ),
				'settings-field' => '_premise_design_settings',
		);

		/** (ALL) Button configuration settings (combined) */
		$options[ 'buttons' ] = array(
				'label'          => __( 'Premise all Configured Buttons', 'premise-settings-transporter' ),
				'settings-field' => '_premise_configured_buttons',
		);

		/** Include Premise 'Custom Code' settings */
		$options[ 'customcode' ] = array(
				'label'          => __( 'Premise Custom Code', 'premise-settings-transporter' ),
				'settings-field' => 'premise-custom',
		);

		/** If active, include Premise's "Member Access" module settings */
		if ( defined( 'MEMBER_ACCESS_SETTINGS_FIELD' ) ) {

			$options[ 'memberaccess' ] = array(
					'label'          => __( 'Member Access Module Settings', 'premise-settings-transporter' ),
					'settings-field' => MEMBER_ACCESS_SETTINGS_FIELD,
			);

		}

		return (array) apply_filters( 'prst_filter_premise_export_options', $options );

	}  // end of method get_export_options


	/**
	 * Echo out the checkboxes for the export options.
	 *
	 * @since  1.0.0
	 *
	 * @uses   DDW_Premise_Admin_Import_Export::get_export_options() Get array of export options
	 *
	 * @return null Returns null if there are no options to export
	 */
	protected function export_checkboxes() {

		if ( ! $options = $this->get_export_options() ) {

			/** Not even the Premise / Member Access export options were returned from the filter */
			printf( '<p><em>%s</em></p>', __( 'No export options available.', 'premise-settings-transporter' ) );
			return;

		}  // end-if

		foreach ( $options as $name => $args ) {

			/** Ensure option item has an array key, and that label and settings-field appear populated */
			if ( is_int( $name )
				|| ! isset( $args[ 'label' ] )
				|| ! isset( $args[ 'settings-field' ] )
				|| '' === $args[ 'label' ]
				|| '' === $args[ 'settings-field' ]
			) {
				return;
			}

			//echo '<p><input id="premise-export-' . esc_attr( $name ) . '" name="premise-export[' . esc_attr( $name ) . ']" type="checkbox" value="1" />';
			//echo ' <label for="premise-export-' . esc_attr( $name ) . '">' . esc_html( $args[ 'label' ] ) . '</label></p>' . "\n";

			printf(
				'<p><label for="premise-export-%1$s"><input id="premise-export-%1$s" name="premise-export[%1$s]" type="checkbox" value="1" class="prstselect" /> %2$s</label></p>',
				esc_attr( $name ),
				esc_html( $args[ 'label' ] )
			);

		}  // end foreach

	}  // end of method export_checkboxes


	/**
	 * Generate the export file, if requested, in JSON format.
	 *
	 * After checking we're on the right page, and trying to export, loop
	 *    through the list of requested options to export, grabbing the settings
	 *    from the database, and building up a file name that represents that
	 *    collection of settings.
	 *
	 * A .json file is then sent to the browser, named with "premise" at the
	 *    start and ending with the current date-time.
	 *
	 * The 'prst_premise_export' action is fired after checking we can proceed,
	 *    but before the array of export options are retrieved.
	 *
	 * @since  1.0.0
	 *
	 * @uses   accesspress_is_admin_page() Check if we're on a Premise/ MemberAccess page
	 * @uses   DDW_Premise_Admin_Import_Export::get_export_options() Get array of export options
	 *
	 * @return null Returns null if not correct page, or we're not exporting
	 */
	public function export() {

		/** Check we're on the Import / Export page */
		if ( ! accesspress_is_menu_page( 'premise-import-export' ) ) {
			return;
		}

		/** Check we're trying to export */
		if ( empty( $_REQUEST[ 'premise-export' ] ) ) {
			return;
		}

		/** Verify nonce */
		check_admin_referer( 'premise-export' );

		/** Hookable */
		do_action( 'prst_premise_export', $_REQUEST[ 'premise-export' ] );

		/** Get array of available options that can be exported */
		$options = $this->get_export_options();

		$settings = array();

		/** Exported file name always starts with "premise" */
		$prefix = array( 'premise-settings-transporter' );

		/** Loop through set(s) of options */
		foreach ( (array) $_REQUEST[ 'premise-export' ] as $export => $value ) {

			/** Grab settings field name (key) */
			$settings_field = $options[ $export ][ 'settings-field' ];

			/** Grab all of the settings from the database under that key */
			$settings[$settings_field] = get_option( $settings_field );

			/* Add name of option set to build up export file name */
			$prefix[] = $export;

		}  // end foreach

		/** Check there's something to export */
		if ( ! $settings ) {
			return;
		}

		/** Complete the export file name by joining parts together */
		$prefix = join( '-', $prefix );

	    $output = json_encode( (array) $settings );

		/** Prepare and send the export file to the browser */
	    header( 'Content-Description: File Transfer' );
	    header( 'Cache-Control: public, must-revalidate' );
	    header( 'Pragma: hack' );
	    header( 'Content-Type: text/plain' );
	    header( 'Content-Disposition: attachment; filename="' . $prefix . '-' . date( 'Ymd-His' ) . '.json"' );
	    header( 'Content-Length: ' . strlen( $output ) );
	    echo $output;
	    exit;

	}  // end of method export


	/**
	 * Handles the imported file.
	 *
	 * Upon upload, the file contents are JSON-decoded. If there were errors,
	 *    or no options to import, then reload the page to show an error message.
	 *
	 * Otherwise, loop through the array of option sets, and update the data
	 *    under those keys in the database. Afterwards, reload the page with a
	 *    success message.
	 *
	 * Calls premise_import action is fired after checking we can proceed, but
	 *    before attempting to extract the contents from the uploaded file.
	 *
	 * @since  1.0.0
	 *
	 * @uses   accesspress_is_admin_page() Check if we're on a Premise/ MemberAccess page
	 * @uses   premise_admin_redirect() Redirect user to an admin page
	 *
	 * @return null Returns null if not correct admin page, we're not importing
	 */
	public function import() {

		/** Check we're on our own Import / Export page */
		if ( ! accesspress_is_menu_page( 'premise-import-export' ) ) {
			return;
		}

		/** Check we're trying to import */
		if ( empty( $_REQUEST['premise-import'] ) ) {
			return;
		}

		/** Verify nonce */
		check_admin_referer( 'premise-import' );

		/** Hookable */
		do_action( 'prst_premise_import', $_REQUEST[ 'premise-import' ], $_FILES[ 'premise-import-upload' ] );

		/** Extract file contents */
		$upload = file_get_contents( $_FILES[ 'premise-import-upload' ][ 'tmp_name' ] );

		/** Decode the JSON */
		$options = json_decode( $upload, true );

		/** Check for errors */
		if ( ! $options || $_FILES[ 'premise-import-upload' ][ 'error' ] ) {
			premise_admin_redirect( 'premise-import-export', array( 'error' => 'true' ) );
			exit;
		}

		/** Cycle through data, import settings */
		foreach ( (array) $options as $key => $settings ) {
			update_option( $key, $settings );
		}

		/** Redirect, add success flag to the URI */
		premise_admin_redirect( 'premise-import-export', array( 'imported' => 'true' ) );
		exit;

	}  // end of method import

}  // end of main class DDW_Premise_Admin_Import_Export