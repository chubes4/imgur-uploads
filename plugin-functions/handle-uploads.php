<?php

// AJAX actions
add_action('wp_ajax_imgur_image_upload', 'handle_imgur_image_upload');

function handle_imgur_image_upload() {
    check_ajax_referer('imgur_image_upload_nonce', 'nonce');
    
    $file = $_FILES['image'];
    if (!$file) {
        wp_send_json_error(array('message' => 'No file uploaded.'));
        return;
    }

    $client_id = get_option('imgur_client_id');
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
    curl_setopt($curl, CURLOPT_POSTFIELDS, array('image' => base64_encode(file_get_contents($file['tmp_name']))));
    
    $response = curl_exec($curl);
    curl_close($curl);
    
    $data = json_decode($response, true);
    
    if ($data['success']) {
        wp_send_json_success(array('url' => $data['data']['link']));
    } else {
        wp_send_json_error(array('message' => 'Upload to Imgur failed.'));
    }
}
