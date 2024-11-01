<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.bigg.co.uk
 * @since      1.0.0
 *
 * @package    Traki_Analytics
 * @subpackage Traki_Analytics/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <form method="post" name="cleanup_options" action="options.php">

		<?php settings_fields( $this->plugin_name ); ?>

		<?php
		$options    = get_option( $this->plugin_name );
		$traki_code = $options['traki_code'];
		?>
        <!-- Enter Traki Code -->
        <fieldset>
            <fieldset>
                <p>Enter your Traki code here and you're good to go! - If you do not know how to get your Traki code,
                    get some help over <a href="http://support.traki.co.uk" target="_blank">here</a>.</p>
                <legend class="screen-reader-text">
                    <span><?php _e( 'Enter your Traki code here', $this->plugin_name ); ?></span></legend>
                <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-traki_code"
                       name="<?php echo $this->plugin_name; ?>[traki_code]" value="<?php echo $traki_code; ?>"/>
            </fieldset>
        </fieldset>

		<?php submit_button( 'Update / Validate', 'primary', 'submit', true ); ?>

    </form>
</div>