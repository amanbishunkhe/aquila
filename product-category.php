<?php
// Add custom field to product category edit form
function custom_product_single_category_edit_form_fields($term) {
    $image_url = get_term_meta($term->term_id, 'custom_product_category_image', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="custom_product_category_image"><?php esc_html_e('Category Image', 'text-domain'); ?></label>
        </th>
        <td>
            <div id="custom_product_category_image_container">
                <?php if (!empty($image_url)) : ?>
                    <img src="<?php echo esc_attr($image_url); ?>" style="max-width: 100px;">
                <?php endif; ?>
            </div>
            <input type="hidden" name="custom_product_category_image" id="custom_product_category_image" value="<?php echo esc_attr($image_url); ?>">
            <button id="upload_image_button" class="button"><?php esc_html_e('Upload Image', 'text-domain'); ?></button>
        </td>
    </tr>
    <script type="text/javascript" >
        jQuery(document).ready(function($) {
            $('#upload_image_button').click(function(e) {
                e.preventDefault();
                var image_frame;
                console.log( image_frame );
                if (image_frame) {
                    image_frame.open();
                    return;
                }
                image_frame = wp.media.frames.downloadable_file = wp.media({
                    title: '<?php esc_html_e('Choose Image', 'text-domain'); ?>',
                    button: {
                        text: '<?php esc_html_e('Insert Image', 'text-domain'); ?>'
                    },
                    multiple: false
                });

                
                image_frame.on('select', function() {
                    var attachment = image_frame.state().get('selection').first().toJSON();
                    $('#custom_product_category_image').val(attachment.url);
                    $('#custom_product_category_image_container').html('<img src="' + attachment.url + '" style="max-width: 100px;">');
                });
                image_frame.open();
            });
        });

    </script>
    <?php
}
add_action('product_cat_edit_form_fields', 'custom_product_single_category_edit_form_fields');

// Save custom field data when product category is updated
function save_custom_single_product_category_field($term_id) {
    if (isset($_POST['custom_product_category_image'])) {
        update_term_meta($term_id, 'custom_product_category_image', $_POST['custom_product_category_image']);
    }
}
add_action('edited_product_cat', 'save_custom_single_product_category_field');

