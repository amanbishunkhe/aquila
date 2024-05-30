jQuery(document).ready(function($){
    function openMediaUploader(button) {
        var custom_uploader = wp.media({
            title: 'Select Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            button.siblings('.image-upload-input').val(attachment.url);
            button.closest('p').siblings('p').find('img.image-preview').attr('src', attachment.url);
        }).open();
    }

    $(document).on('click', '.image-upload-button', function(e) {
        e.preventDefault();
        openMediaUploader($(this));
    });
});
