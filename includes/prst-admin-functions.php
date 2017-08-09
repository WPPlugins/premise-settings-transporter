<?php
/**
 * Admin helper functions.
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


add_action( 'prst_premise_import_export_form', 'ddw_prst_exporter_notice' );
/**
 * Adds an extra info message at the bottom of the Genesis Exporter page,
 *    informing the user that there's no warranty supplied for the use of this plugin!
 *
 * @since  1.0.0
 *
 * @uses   ddw_prst_plugin_help_content_faq() To display FAQ help content.
 */
function ddw_prst_exporter_notice() {

	/** Begin table code */
	?>

		<tr>
			<th scope="row"><h4>&rarr; <?php echo sprintf( __( 'Notes for the %s plugin', 'premise-settings-transporter' ), '&raquo;' . __( 'Premise Settings Transporter', 'premise-settings-transporter' ) . '&laquo;' ); ?>:</h4></th>
				<td>
					<p>
						<div class="premise-option-box"><?php _e( 'There\'s NO warranty supplied when you use this plugin, all at your own risk!', 'premise-settings-transporter' ); ?></div>
					</p>
					<?php echo ddw_prst_plugin_help_content_faq(); ?>
				</td>
		</tr>

	<?php
	/** ^End table code */

}  // end of function ddw_prst_exporter_notice