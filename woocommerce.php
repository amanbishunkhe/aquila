<?php
/**
 * Breadcrumbs.
 *
 * @see woocommerce_breadcrumb()
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

/**
 * 
 * remove shop page title 
 */

add_filter( 'woocommerce_show_page_title', 'readymix_hide_shop_page_title' ); 
function readymix_hide_shop_page_title( $title ) {
   if ( is_shop() ) $title = false;
   return $title;
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

function custom_products_display(){
   $category_option = get_field('wc_select_category','option');
   ?>
   <section class="section-products section-product-alt" style="background-color: #FDD9ED;">      
      <div class="container">
         <div class="section-title" >
            <h2><?php echo 'Popular Merchandise'; ?></h2>
         </div>
         <div class="products-grid">
               <?php
               $wc_products_args = array();
               if( !empty( $category_option ) ){
                  $wc_products_args =  array( 
                     'post_type' => 'product',
                     'post_status' => 'publish',
                     'posts_per_page' => 4,
                     'tax_query' => array(
                           array(
                              'taxonomy' => 'product_cat',
                              'field'    => 'term_id',
                              'terms'    => $category_option,
                              ),
                     ),
                  );
               }else{
                  $wc_products_args = array(
                     'post_type' => 'product',
                     'posts_per_page' => 4,
                     'post_status' => 'publish',
                  );
               }   
               
               // echo '<pre>';print_r($wc_products_args);echo '</pre>';
      
               $wc_products_query = new WP_Query( $wc_products_args ); 

               while ($wc_products_query->have_posts()) {
                  $wc_products_query->the_post();
                  $post_thumbnail_id = get_post_thumbnail_id($post->ID);
                  // $full_size_image   = wp_get_attachment_image_src($post_thumbnail_id, 'full');
                  $terms = get_the_terms(get_the_ID(), 'product_cat');
                  $product = wc_get_product( get_the_ID() );
                  //echo '<pre>';print_r($terms);echo '</pre>';
               ?>
                  <div class="product-card product-card-<?php echo $post->ID; ?>">
                     <div class="card-inner">
                           <div class="card-image">
                              <a href="<?php the_permalink(); ?>">
                                 <?php echo get_the_post_thumbnail('', 'large'); ?>
                              </a>
                           </div>
                           <div class="card-content no-cart-btn">
                              <div class="content-inner">
                                 <h3>
                                       <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                       <div class="category">
                                          <span><?php _e('Lorem', 'readymix'); ?></span>
                                       </div>
                                 </h3>
                                 <?php if ($price_html = $product->get_price_html()) : ?>
                                       <div class="price"><?php echo $price_html; ?></div>
                                 <?php endif; ?>
                              </div>
                              <div class="button-wrap">
                                 <?php woocommerce_template_loop_add_to_cart(); ?>
                              </div>
                           </div>
                     </div>
                  </div>
               <?php
               }
               wp_reset_postdata();
               ?>
         </div>
      </div>
   </section>
   <?php   
}
add_action('woocommerce_after_single_product_summary','custom_products_display');


remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );


//Adding descriptions accordion under the product summary
add_action( 'woocommerce_single_product_summary', function () {

   $readymix_shipping_details = get_field('readymix_shipping_details','option');
   $readymix_return_details = get_field('readymix_return_details','option');
	?>
	<div class="product-detail-accordion">
		<div class="detail-accordion-wrap">
			<?php
			$productContent = get_the_content();
			if ( $productContent ) {
				?>
				<div class="accordion-item">
					<div class="accordion-head" tabindex="0">
						<h5 class="accordion-title"><?php _e( 'Details', 'readymix' ); ?></h5>
						<span class="accordion-icon"></span>
					</div>
					<div class="accordion-body">
						<div class="accordion-body-inner">
							<?php
							the_content();
							?>
						</div>
					</div>
				</div>
				<?php
			}
			if ( get_field( 'readymix_shipping_details', 'option' ) ) {
				?>
				<div class="accordion-item">
					<div class="accordion-head" tabindex="0">
						<h5 class="accordion-title"><?php _e( 'Shipping', 'readymix' ); ?></h5>
						<span class="accordion-icon"></span>
					</div>
					<div class="accordion-body">
						<div class="accordion-body-inner">
							<?php the_field( 'readymix_shipping_details', 'option' ); ?>
						</div>
					</div>
				</div>
				<?php
			}
			if ( get_field( 'readymix_return_details', 'option' ) ) {
				?>
				<div class="accordion-item">
					<div class="accordion-head" tabindex="0">
						<h5 class="accordion-title"><?php _e( 'Returns', 'readymix' ); ?></h5>
						<span class="accordion-icon"></span>
					</div>
					<div class="accordion-body">
						<div class="accordion-body-inner">
							<?php the_field( 'readymix_return_details', 'option' ); ?>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}, 61 );


add_filter( 'woocommerce_product_tabs', 'remove_product_tabs', 98 );

function remove_product_tabs( $tabs ) {
    unset( $tabs['description'] );        // Remove the description tab
    unset( $tabs['reviews'] );            // Remove the reviews tab
    unset( $tabs['additional_information'] ); // Remove the additional information tab
    return $tabs;
}

// Remove product categories from single product page
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );


// WooCommerce Gallery Slider Controls
function bd_wc_gallery_options( $options ) {

   $options['directionNav'] = true;
   $options['controlNav'] = true;
   return $options;
}
add_filter( 'woocommerce_single_product_carousel_options', 'bd_wc_gallery_options' );

function add_buy_now_button() {
   global $product;

   $buy_now_url = add_query_arg(
       array(
           'add-to-cart' => $product->get_id(),
           'quantity' => 1
       ),
       home_url('/checkout/')
   );

   echo '<a href="' . esc_url( $buy_now_url ) . '" class="button buy-now-button">' . __( 'Buy Now', 'woocommerce' ) . '</a>';
}

add_action( 'woocommerce_after_add_to_cart_button', 'add_buy_now_button' );
