<?php
// Registers the TinyMCE plugin & enqueues script

// Enqueue scripts and localize
add_action('wp_enqueue_scripts', function() {
    if (function_exists('is_bbpress') && is_bbpress()) {
        wp_enqueue_script('imgur-tinymce-upload', IMGUR_UPLOADS_PLUGIN_URL . 'js/tinymce-imgur-upload.js', array('jquery'), '1.0', true);
        
        wp_localize_script('imgur-tinymce-upload', 'imgurAjax', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('imgur_image_upload_nonce'),
        ));
        
        add_action('wp_footer', function() {
            echo '<input type="file" id="imgur-file-input" style="display: none;" />';
        });
    }
});

function register_imgur_upload_tinymce_plugin($plugin_array) {
    // Specify the URL to your TinyMCE plugin's JavaScript file
    $plugin_array['imgur_upload_plugin'] = IMGUR_UPLOADS_PLUGIN_URL . 'js/tinymce-imgur-upload.js';
    return $plugin_array;
}
add_filter('mce_external_plugins', 'register_imgur_upload_tinymce_plugin');

function add_imgur_upload_button($buttons) {
    // Add your button's identifier to the array of buttons
    $buttons[] = 'imgur_upload_button';
    return $buttons;
}
add_filter('mce_buttons', 'add_imgur_upload_button'); // Adjust mce_buttons to mce_buttons_2 etc. as needed
