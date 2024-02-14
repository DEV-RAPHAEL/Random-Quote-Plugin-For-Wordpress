<?php
// general-settings.php

// Function to register settings
function random_quote_footer_register_settings() {
    register_setting('random_quote_footer_settings_group', 'random_quote_color');
    register_setting('random_quote_footer_settings_group', 'random_quote_font');
}
add_action('admin_init', 'random_quote_footer_register_settings');

// Display general settings form
?>
<form method="post" action="options.php">
    <?php settings_fields('random_quote_footer_settings_group'); ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Quote Color</th>
            <td><input type="color" name="random_quote_color" value="<?php echo get_option('random_quote_color', '#000000'); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">Quote Font</th>
            <td><input type="text" name="random_quote_font" value="<?php echo get_option('random_quote_font', 'Arial'); ?>"></td>
        </tr>
    </table>
    <h3>Shortcodes</h3>
    <p>Use These shortcodes to add Quotes to your site</p>
    <table>
        <th scope="row">Static Display</th>
        <code>[random_quote]</code>
    </table>
    <br>
    <table>
        <th scope="row">Dynamic Display</th>
        <code>[random_quote_dynamic]</code>
    </table>
    <?php submit_button(); ?>
</form>
?>
