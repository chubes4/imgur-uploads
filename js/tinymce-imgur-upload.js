(function waitForTinyMCE() {
    function initPlugin() {
        tinymce.PluginManager.add('imgur_upload_plugin', function(editor, url) {
            editor.addButton('imgur_upload_button', {
                text: 'Upload Image',
                icon: 'image',
                onclick: function() {
                    // Trigger file input click
                    document.getElementById('imgur-file-input').click();
                }
            });

            document.getElementById('imgur-file-input').addEventListener('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var formData = new FormData();
                    formData.append('action', 'imgur_image_upload'); // WordPress AJAX action
                    formData.append('nonce', imgurAjax.nonce); // Security nonce
                    formData.append('image', file, file.name);

                    jQuery.ajax({
                        url: imgurAjax.ajaxUrl,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.success) {
                                editor.insertContent('<img src="' + response.data.url + '" />');
                            } else {
                                alert('Upload failed: ' + response.data.message);
                            }
                        }
                    });
                }
            });
        });
    }

    if (window.tinymce) {
        initPlugin();
    } else {
        setTimeout(waitForTinyMCE, 100);
    }
})();
