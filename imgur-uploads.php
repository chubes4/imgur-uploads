<?php
/**
 * Plugin Name: Imgur Uploads
 * Description: This plugin allows users to upload images to Imgur and insert them into WordPress / BBpress posts.
 * Version: 1.0
 * Author: Chris Huber (HuberPress)
 * License: GPL v2 or later
 */

 define('IMGUR_UPLOADS_PLUGIN_URL', plugin_dir_url(__FILE__));



// Include all PHP files from the plugin-functions directory
foreach (glob(plugin_dir_path(__FILE__) . 'plugin-functions/*.php') as $filename) {
    include_once $filename;
}
?>
