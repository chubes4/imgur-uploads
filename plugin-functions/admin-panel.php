<?php

// Register settings page
add_action('admin_menu', function() {
    add_options_page('Imgur Upload Settings', 'Imgur Upload', 'manage_options', 'imgur-upload-settings', 'imgur_upload_settings_page');
});

// Register setting
add_action('admin_init', function() {
    register_setting('imgur-upload-settings-group', 'imgur_client_id');
});

// Settings page content
function imgur_upload_settings_page() {
    ?>
    <div class="wrap">
        <h1>Imgur Upload Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('imgur-upload-settings-group'); ?>
            <?php do_settings_sections('imgur-upload-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                <th scope="row">Imgur Client ID</th>
                <td><input type="text" name="imgur_client_id" value="<?php echo esc_attr(get_option('imgur_client_id')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
