<?php
// Option page registration.
add_action(
	'acf/init',
	function () {
		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page(
				array(
					'page_title' => 'Readymix Settings',
					'menu_title' => 'Readymix Settings',
					'menu_slug'  => 'readymix-general-settings',
					'capability' => 'edit_posts',
					'redirect'   => false,
				)
			);
			// acf_add_options_sub_page( array(
			// 'page_title'  => 'Email Routing',
			// 'menu_title'  => 'Email Recipient',
			// 'parent_slug' => 'readymix-general-settings',
			// ) );
			// acf_add_options_sub_page( array(
			// 'page_title'  => 'Footer Settings',
			// 'menu_title'  => 'Footer',
			// 'parent_slug' => 'readymix-general-settings',
			// ) );
		}
	}
);
/*
* Only allow the block types created by ACF
*/
// add_filter( 'allowed_block_types', 'readymix_allowed_block_types', 10, 2 );
// function readymix_allowed_block_types( $allowed_blocks, $post ) {
// $allowed_blocks = array(
// 'core/readymix-banner', //This is included to show the reusable block
// 'core/readymix-usps'
// );
//
// return $allowed_blocks;
// }

add_action( 'acf/init', 'readymix_acf_block_types' );
function readymix_acf_block_types() {
	// Check function exists.
	if ( function_exists( 'acf_register_block_type' ) ) {

		$block_arrays = array(
			array(
				'name'            => 'readymix-banner',
				'title'           => __( 'Banner', 'readymix' ),
				'description'     => __( 'Single image or video or sliders', 'readymix' ),
				'render_template' => 'template-parts/blocks/banner.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'images-alt2',
				'keywords'        => array( 'banner', 'banner video', 'banner slider' ),
				'post_types'      => array( 'page', 'readymix_product', 'guide-article' )
			),

			array(
				'name'            => 'readymix-usps',
				'title'           => __( 'USP', 'readymix' ),
				'description'     => __( '', 'readymix' ),
				'render_template' => 'template-parts/blocks/usps.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'yes-alt',
				'keywords'        => array( 'usp' ),
				'post_types'      => array( 'page' )				
			)
		);
	/* 	echo '<pre>';
		print_r($block_arrays);
		echo '</pre>'; */

		foreach ($block_arrays as $key => $block_array) {
			acf_register_block_type(
				array(
					'name'				=> $block_array['name'],
					'title'           	=> $block_array['title'],
					'description'     	=> $block_array['description'],
					'render_template' 	=> $block_array['render_template'],
					'category'        	=> $block_array['name'],
					// 'icon'              => 'images-alt2',
					'keywords'        	=> $block_array['keywords'],
					'post_types'      	=> $block_array['post_types'],
					'mode'            => 'edit',
					'supports'        => array(
						'mode' => false,
						'anchor' => true
					),
				)
			);
		}
		/*
		// Register banner block.
		acf_register_block_type(
			array(
				'name'            => 'readymix-banner',
				'title'           => __( 'Banner', 'readymix' ),
				'description'     => __( 'Single image or video or sliders', 'readymix' ),
				'render_template' => 'template-parts/blocks/banner.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'images-alt2',
				'keywords'        => array( 'banner', 'banner video', 'banner slider' ),
				'post_types'      => array( 'page', 'readymix_product', 'guide-article' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);
		// Register USPs block
		acf_register_block_type(
			array(
				'name'            => 'readymix-usps',
				'title'           => __( 'USP', 'readymix' ),
				'description'     => __( '', 'readymix' ),
				'render_template' => 'template-parts/blocks/usps.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'yes-alt',
				'keywords'        => array( 'usp' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);
		*/


		// Register why readymix image and content block
		acf_register_block_type(
			array(
				'name'            => 'readymix-why-readymix-image-content',
				'title'           => __( 'Why Readymix: Image and Content', 'readymix' ),
				'description'     => __( '', 'Why Readymix: Image and Content' ),
				'render_template' => 'template-parts/blocks/why-readymix-image-content.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'yes-alt',
				'keywords'        => array( 'why-readymix-image-content' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register Redymix Order Steps
		acf_register_block_type(
			array(
				'name'            => 'readymix-order-steps',
				'title'           => __( 'Redymix Order Steps', 'readymix' ),
				'description'     => __( '', 'Redymix Order Steps' ),
				'render_template' => 'template-parts/blocks/readymix-order-steps.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'yes-alt',
				'keywords'        => array( 'readymix-order-steps' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register why readymix section
		acf_register_block_type(
			array(
				'name'            => 'why-readymix',
				'title'           => __( 'Why Readymix', 'readymix' ),
				'description'     => __( '', 'Why Readymix' ),
				'render_template' => 'template-parts/blocks/why-readymix.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'yes-alt',
				'keywords'        => array( 'why-readymix' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register readymix features block
		acf_register_block_type(
			array(
				'name'            => 'readymix-features',
				'title'           => __( 'Readymix Features Block', 'readymix' ),
				'description'     => __( '', 'Readymix Features Block' ),
				'render_template' => 'template-parts/blocks/readymix-features.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'yes-alt',
				'keywords'        => array( 'readymix-features' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register guided selling cta block
		acf_register_block_type(
			array(
				'name'            => 'guided-selling-cta',
				'title'           => __( 'Readymix Guided Selling CTA', 'readymix' ),
				'description'     => __( '', 'Readymix Guided Selling CTA' ),
				'render_template' => 'template-parts/blocks/guided-selling-cta.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'yes-alt',
				'keywords'        => array( 'guided-selling-cta' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register Brand Family block
		acf_register_block_type(
			array(
				'name'            => 'brand-family-block',
				'title'           => __( 'Brand Family', 'readymix' ),
				'description'     => __( '', 'Brand Family' ),
				'render_template' => 'template-parts/blocks/brand-family-block.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'yes-alt',
				'keywords'        => array( 'brand-family-block' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register Get A Quote block
		acf_register_block_type(
			array(
				'name'            => 'get-a-quote-block',
				'title'           => __( 'Get A Quote', 'readymix' ),
				'description'     => __( '', 'Get A Quote' ),
				'render_template' => 'template-parts/blocks/get-a-quote.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'yes-alt',
				'keywords'        => array( 'get-a-quote-block' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register Image Gallery Showcase
		acf_register_block_type(
			array(
				'name'            => 'image-gallery-showcase',
				'title'           => __( 'Image Gallery Showcase', 'readymix' ),
				'description'     => __( '', 'Image Gallery Showcase' ),
				'render_template' => 'template-parts/blocks/image-gallery-showcase.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'yes-alt',
				'keywords'        => array( 'image-gallery-showcase' ),
				'post_types'      => array( 'page', 'readymix_project' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register Title Content Block
		acf_register_block_type(
			array(
				'name'            => 'title-content-block',
				'title'           => __( 'Title Content Block', 'readymix' ),
				'description'     => __( '', 'Title Content Block' ),
				'render_template' => 'template-parts/blocks/title-content-block.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'yes-alt',
				'keywords'        => array( 'title-content-block' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register Contact Form With CTA and Locations Block
		acf_register_block_type(
			array(
				'name'            => 'contact-form-with-cta-locations',
				'title'           => __( 'Contact Form With CTA Locations', 'readymix' ),
				'description'     => __( '', 'Contact Form With CTA Locations' ),
				'render_template' => 'template-parts/blocks/contact-form-with-cta-locations.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'yes-alt',
				'keywords'        => array( 'contact-form-with-cta-locations' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register Shortcode Block
		acf_register_block_type(
			array(
				'name'            => 'shortcode-block',
				'title'           => __( 'Shortcode Block', 'readymix' ),
				'description'     => __( '', 'Shortcode Block' ),
				'render_template' => 'template-parts/blocks/shortcode-block.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'yes-alt',
				'keywords'        => array( 'shortcode-block' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// 290323

		// Register Lister Introduction block
		acf_register_block_type(
			array(
				'name'            => 'readymix-lister-introduction',
				'title'           => __( 'Lister Introduction', 'readymix' ),
				'description'     => __( '', 'readymix' ),
				'render_template' => 'template-parts/blocks/lister-introduction.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'admin-users',
				'keywords'        => array( 'Lister Introduction' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register Image and Content
		acf_register_block_type(
			array(
				'name'            => 'zig-zag-module',
				'title'           => __( 'Zig Zag module', 'readymix' ),
				'description'     => __( 'Zig Zag module', 'readymix' ),
				'render_template' => 'template-parts/blocks/zig-zag-module.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'admin-users',
				'keywords'        => array( 'Zig Zag', 'Image', 'Content' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register Find Installer block
		acf_register_block_type(
			array(
				'name'            => 'cta-block',
				'title'           => __( 'Readymix cta', 'readymix' ),
				'description'     => __( '', 'readymix' ),
				'render_template' => 'template-parts/blocks/cta-block.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'admin-users',
				'keywords'        => array( 'cta' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register SEO Module
		acf_register_block_type(
			array(
				'name'            => 'content-seo-faqs',
				'title'           => __( 'Content: SEO and FAQs', 'readymix' ),
				'description'     => __( 'Content: SEO and optional FAQs', 'readymix' ),
				'render_template' => 'template-parts/blocks/block-content-seo-faqs.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'admin-users',
				'keywords'        => array( 'seo', 'faqs' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register FAQ module
		acf_register_block_type(
			array(
				'name'            => 'readymix-faqs-listing',
				'title'           => __( 'FAQs Listing', 'readymix' ),
				'description'     => __( 'FAQs Listing', 'readymix' ),
				//'render_callback' => 'render_faqs_listing_block',
				'render_template' => 'template-parts/blocks/faqs-listing.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'admin-users',
				'keywords'        => array( 'faq', 'listing' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Concrete calculator block
		acf_register_block_type(
			array(
				'name'            => 'readymix-concrete-calculator-cta',
				'title'           => __( 'Concrete Calculator CTA', 'readymix' ),
				'description'     => __( 'Concrete Calculator CTA.', 'readymix' ),
				'render_template' => 'template-parts/blocks/concrete-calculator-cta.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'admin-users',
				'keywords'        => array( 'concrete', 'calculator' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register Notice text block
		acf_register_block_type(
			array(
				'name'            => 'readymix-notice-text-block',
				'title'           => __( 'Notice', 'readymix' ),
				'description'     => __( 'Add notice type text.', 'readymix' ),
				'render_template' => 'template-parts/blocks/notice.php',
				'category'        => 'readymix-blocks',
				'keywords'        => array( 'notice' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register Popular Products block
		acf_register_block_type(
			array(
				'name'            => 'readymix-popular-products',
				'title'           => __( 'Popular Products', 'readymix' ),
				'description'     => __( '', 'readymix' ),
				'render_template' => 'template-parts/blocks/popular-products.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'products',
				'keywords'        => array( 'Popular Products' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// register concrete calculator block
		acf_register_block_type(
			array(
				'name'            => 'readymix-concrete-calculator',
				'title'           => __( 'Concrete Calculator', 'readymix' ),
				'description'     => __( 'Concrete Calculator', 'readymix' ),
				'render_template' => 'template-parts/blocks/concrete-calculator.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'admin-users',
				'keywords'        => array( 'concrete', 'calculator' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register Service Areas block
		acf_register_block_type(
			array(
				'name'            => 'readymix-service-areas',
				'title'           => __( 'Service Areas', 'readymix' ),
				'description'     => __( 'Service Areas', 'readymix' ),
				'render_template' => 'template-parts/blocks/service-areas-block.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'admin-users',
				'keywords'        => array( 'service', 'areas' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register Testimonial block
		acf_register_block_type(
			array(
				'name'            => 'readymix-testimonial',
				'title'           => __( 'Testimonial', 'readymix' ),
				'description'     => __( 'Testimonial', 'readymix' ),
				'render_template' => 'template-parts/blocks/testimonial-block.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'admin-users',
				'keywords'        => array( 'Testimonial' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// register Readymix Projects Block
		acf_register_block_type(
			array(
				'name'            => 'readymix-projects-block',
				'title'           => __( 'Readymix Projects Block', 'readymix' ),
				'description'     => __( 'Readymix Projects Block', 'readymix' ),
				'render_template' => 'template-parts/blocks/readymix-projects-block.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'admin-users',
				'keywords'        => array( 'projects' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);		

		// Register Page Products block
		acf_register_block_type( array(
			'name'            => 'readymix-popular-products-with-Details',
			'title'           => __( 'Readymix Products With Details', 'readymix' ),
			'description'     => __( '', 'readymix' ),
			'render_template' => 'template-parts/blocks/popular-products-with-details.php',
			'category'        => 'readymix-blocks',
			// 'icon'              => 'welcome-learn-more',
			'keywords'        => array( 'products', 'readymix' ),
			'post_types'      => array( 'page' ),
			'mode'            => 'edit',
			'supports'        => array(
				'mode' => false,
				'anchor' => true
			),
		) );		

		// Register Page Projects Showcase block
		acf_register_block_type( array(
			'name'            => 'readymix-projects-showcase',
			'title'           => __( 'Readymix Projects Showcase', 'readymix' ),
			'description'     => __( '', 'readymix' ),
			'render_template' => 'template-parts/blocks/projects-showcase.php',
			'category'        => 'readymix-blocks',
			// 'icon'              => 'welcome-learn-more',
			'keywords'        => array( 'projects', 'readymix' ),
			'post_types'      => array( 'page' ),
			'mode'            => 'edit',
			'supports'        => array(
				'mode' => false,
				'anchor' => true
			),
		) );
		
		// Register Instagaram Pinterest Block
		// acf_register_block_type( array(
		// 	'name'            => 'readymix-insta',
		// 	'title'           => __( 'Instagram', 'readymix' ),
		// 	'description'     => __( '', 'readymix' ),
		// 	'render_template' => 'template-parts/blocks/instagram.php',
		// 	'category'        => 'readymix-blocks',
		// 	// 'icon'              => 'admin-users',
		// 	'keywords'        => array( 'instagram', 'insta' ),
		// 	'post_types'      => array( 'page', 'readymix_product' ),
		// 	'mode'            => 'edit',
		// 	'supports'        => array(
		// 		'mode' => false,
		// 	),
		// ) );

		// Register Instagaram Pinterest Block
		acf_register_block_type( array(
			'name'            => 'readymix-new-insta-pinterest',
			'title'           => __( 'Instagram/Pinterest', 'readymix' ),
			'description'     => __( '', 'readymix' ),
			'render_template' => 'template-parts/blocks/insta-pinterest.php',
			'category'        => 'readymix-blocks',
			// 'icon'              => 'admin-users',
			'keywords'        => array( 'instagram', 'pinterest', 'insta' ),
			'post_types'      => array( 'page', 'readymix_product' ),
			'mode'            => 'edit',
			'supports'        => array(
				'mode' => false,
				'anchor' => true
			),
		) );

		// Register woocommerce Block
		acf_register_block_type( array(
			'name'            => 'readymix-woocommerce-products',
			'title'           => __( 'woocommerce/products', 'readymix' ),
			'description'     => __( '', 'readymix' ),
			'render_template' => 'template-parts/blocks/woocommerce-products.php',
			'category'        => 'readymix-blocks',
			// 'icon'              => 'admin-users',
			'keywords'        => array( 'products'),
			'post_types'      => array( 'page', 'readymix_product' ),
			'mode'            => 'edit',
			'supports'        => array(
				'mode' => false,
				'anchor' => true
			),
		) );
		
		
		// Register Hero Slider Block
		acf_register_block_type( array(
			'name'            => 'readymix-hero-slider',
			'title'           => __( 'Hero Slider', 'readymix' ),
			'description'     => __( '', 'readymix' ),
			'render_template' => 'template-parts/blocks/hero-slider.php',
			'category'        => 'readymix-blocks',
			// 'icon'              => 'admin-users',
			'keywords'        => array( 'page'),
			'post_types'      => array( 'page', 'readymix_project' ),
			'mode'            => 'edit',
			'supports'        => array(
				'mode' => false,
				'anchor' => true
			),
		) );
		
		// new display center listing block

		acf_register_block_type(
			array(
				'name'            => 'readymix-display-centre-filter-listing-block',
				'title'           => __( 'Display Centre: Filter and Listing New', 'readymix' ),
				'description'     => __( 'Display Centre filter and listing new.', 'readymix' ),
				'render_template' => 'template-parts/blocks/display-center-filter-listing-new.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'admin-users',
				'keywords'        => array( 'display', 'centre', 'listing' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

		// Register woocommerce Block
		acf_register_block_type( array(
			'name'            => 'readymix-single-project-title-area',
			'title'           => __( 'Readymix Project Title area', 'readymix' ),
			'description'     => __( '', 'readymix' ),
			'render_template' => 'template-parts/blocks/project-title-area.php',
			'category'        => 'readymix-blocks',
			// 'icon'              => 'admin-users',
			'keywords'        => array( 'products'),
			'post_types'      => array( 'page', 'readymix_project' ),
			'mode'            => 'edit',
			'supports'        => array(
				'mode' => false,
				'anchor' => true
			),
		) );

		acf_register_block_type(
			array(
				'name'            => 'readymix-project-with-content-sidebar',
				'title'           => __( 'Project Showcase Content With Sidebar', 'readymix' ),
				'description'     => __( 'Project Showcase Content With Sidebar', 'readymix' ),
				'render_template' => 'template-parts/blocks/project-with-content-sidebar.php',
				'category'        => 'readymix-blocks',
				// 'icon'              => 'admin-users',
				'keywords'        => array( 'title' ),
				'post_types'      => array( 'page', 'readymix_project' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);


		/* // Register image gallery block
		acf_register_block_type( array(
			'name'            => 'readymix-image-showcase',
			'title'           => __( 'Image Showcase', 'readymix' ),
			'description'     => __( 'Image Gallery Showcase', 'readymix' ),
			'render_template' => 'template-parts/blocks/image-gallery-showcase.php',
			'category'        => 'readymix-blocks',
			// 'icon'              => 'admin-users',
			'keywords'        => array( 'gallery', 'image', 'showcase' ),
			'post_types'      => array( 'page', 'readymix_product', 'readymix_project' ),
			'mode'            => 'edit',
			'supports'        => array(
				'mode' => false,
			),
		) ); */

		acf_register_block_type( array(
			'name'            => 'readymix-related-projects',
			'title'           => __( 'Related Projects', 'readymix' ),
			'description'     => __( 'Display related projects.', 'readymix' ),
			'render_template' => 'template-parts/blocks/related-projects.php',
			'category'        => 'readymix-blocks',
			// 'icon'              => 'admin-users',
			'keywords'        => array( 'related', 'project' ),
			'post_types'      => array( 'readymix_project' ),
			'mode'            => 'edit',
			'supports'        => array(
				'mode' => false,
				'anchor' => true
			),
		) );

		// Register Product Filter and Listing Block, for product lister page
		acf_register_block_type(
			array(
				'name'            => 'readymix-product-filter-listing',
				'title'           => __( 'Product Filter Listing', 'readymix' ),
				'description'     => __( 'Product filter and listing', 'readymix' ),
				'render_template' => 'template-parts/blocks/product-filter-listing.php',
				'category'        => 'formatting',
				//'icon'            => 'dashicons-filter',
				'keywords'        => array( 'listing', 'product', 'filter' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);	
			// Register Update Projects
		acf_register_block_type(
			array(
				'name'            => 'readymix-update-projects',
				'title'           => __( 'Readymix Update Projects', 'readymix' ),
				'description'     => __( 'Projects Display', 'readymix' ),
				'render_template' => 'template-parts/blocks/updated-projects.php',
				'category'        => 'formatting',
				//'icon'            => 'dashicons-filter',
				'keywords'        => array( 'projects', 'display' ),
				'post_types'      => array( 'page' ),
				'mode'            => 'edit',
				'supports'        => array(
					'mode' => false,
					'anchor' => true
				),
			)
		);

	}
}
