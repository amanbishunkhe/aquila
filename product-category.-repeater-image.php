<?php
// Add custom field to product category edit form
function custom_product_category_edit_form_fields($term) {
    $image_repeater = get_term_meta($term->term_id, 'custom_product_category_image_repeater', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="custom_product_category_image_repeater"><?php esc_html_e('Image Repeater', 'text-domain'); ?></label>
        </th>
        <td>
            <div id="custom_product_category_image_repeater_container">
                <?php if (!empty($image_repeater)) :
                    foreach ($image_repeater as $index => $image) : ?>
                        <div class="image-repeater-item">
                            <img src="<?php echo esc_attr($image['url']); ?>" style="max-width: 100px;">
                            <input type="hidden" name="custom_product_category_image_repeater[<?php echo esc_attr($index); ?>][url]" value="<?php echo esc_attr($image['url']); ?>">
                            <button class="remove_image_repeater_item button"><?php esc_html_e('Remove', 'text-domain'); ?></button>
                        </div>
                <?php endforeach;
                endif; ?>
            </div>
            <button id="upload_image_button" class="button"><?php esc_html_e('Upload Image', 'text-domain'); ?></button>
        </td>
    </tr>
    <script type="text/javascript" >
        jQuery(document).ready(function($) {
            $('#upload_image_button').click(function(e) {
                e.preventDefault();
                var image_repeater_frame;
                if (image_repeater_frame) {
                    image_repeater_frame.open();
                    return;
                }
                image_repeater_frame = wp.media.frames.downloadable_file = wp.media({
                    title: '<?php esc_html_e('Choose Image', 'text-domain'); ?>',
                    button: {
                        text: '<?php esc_html_e('Insert Image', 'text-domain'); ?>'
                    },
                    multiple: true
                });
                image_repeater_frame.on('select', function() {
                    var selection = image_repeater_frame.state().get('selection');
                    var images = [];
                    selection.map(function(attachment) {
                        attachment = attachment.toJSON();
                        images.push(attachment.url);
                    });
                    var $container = $('#custom_product_category_image_repeater_container');
                    images.forEach(function(image) {
                        $container.append('<div class="image-repeater-item"><img src="' + image + '" style="max-width: 100px;"><input type="hidden" name="custom_product_category_image_repeater[][url]" value="' + image + '"><button class="remove_image_repeater_item button"><?php esc_html_e('Remove', 'text-domain'); ?></button></div>');
                    });
                });
                image_repeater_frame.open();
            });

            $('#custom_product_category_image_repeater_container').on('click', '.remove_image_repeater_item', function(e) {
                e.preventDefault();
                $(this).parent().remove();
            });
        });
    </script>
    <?php
}
add_action('product_cat_edit_form_fields', 'custom_product_category_edit_form_fields');

// Save custom field data when product category is updated
function save_custom_product_category_field($term_id) {
    if (isset($_POST['custom_product_category_image_repeater'])) {
        update_term_meta($term_id, 'custom_product_category_image_repeater', $_POST['custom_product_category_image_repeater']);
    }
}
add_action('edited_product_cat', 'save_custom_product_category_field');
