<?php
// Get block values
$image = get_field('background_image');
$title = get_field('title');
$button_text = get_field('button_text');
$button_url = get_field('button_url');
?>

<div class="image-background-block" style="background-image: url('<?php echo esc_url($image['url']); ?>');">
    <div class="block-content">
        <?php if ($title): ?>
            <h2><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        <?php if ($button_text && $button_url): ?>
            <a href="<?php echo esc_url($button_url); ?>" class="block-button"><?php echo esc_html($button_text); ?></a>
        <?php endif; ?>
    </div>
</div>


<?php
// add this in funcitons.php
function register_acf_blocks() {
    // Check function exists.
    if( function_exists('acf_register_block_type') ) {
        acf_register_block_type(array(
            'name'              => 'image-background-block',
            'title'             => __('Image Background Block'),
            'description'       => __('A custom block with an image background, title, and link button.'),
            'render_template'   => 'template-parts/blocks/image-background-block.php',
            'category'          => 'formatting',
            'icon'              => 'format-image',
            'keywords'          => array( 'image', 'background', 'title', 'button' ),
            'enqueue_assets'    => []
        ));
    }
}
add_action('acf/init', 'register_acf_blocks');

// and create a new field under the image-background-block in acf with above name
// create a folder insite temtplate parts named "blocks" and inside
// image-background-block.php file also, above code is of same file