<?php
/**
 * Product filter listing block
 * For product filtering and listing for lister page like drive ways
 */
//style attribute according to section colour
?>
<?php if ( is_page() ) { ?>

    <?php
    //section background
    $style_bg       = '';
    $section_colour = get_field( 'section_colour' );
    if ( $section_colour ) {
        $style_bg = "style='background-color:" . $section_colour . ";'";
    }

    //Get section title
    //For normal product lister page (e.g driveways)
    $section_title = get_field( 'section_name' );
    //If product is similar product listing page
    // if ( $similar_product_page = geostone_default_page( '_geostone_similar_products_page' ) ) {
    //  if ( is_page( $similar_product_page->ID ) ) {
    //      if ( isset( $_GET['stone'] ) && ! empty( $_GET['stone'] ) ) {
    //          $section_title = __( 'Similar Products to ', 'geostone' ) . get_the_title( $_GET['stone'] ) . __( ' Mix', 'geostone' );
    //      } else {
    //          $section_title = __( 'Find Geostone products available in your area', 'geostone' );
    //      }
    //  }

    // }

    //post type and taxonomy
    $geostone_cpt_type = 'geostone_product';
    $geostone_taxonomy = 'geostone_state';
    $geostone_type_taxonomy = 'geostone_type';

    //Get states and regions(terms) of taxonmy(geostone state)
    $states = get_terms(
        array(
            'taxonomy'   => $geostone_taxonomy,
            'hide_empty' => false
        )
    );

    $types = get_terms(
        array(
            'taxonomy'   => $geostone_type_taxonomy,
            'hide_empty' => false
        )
    );

    //default values of variables
    $args             = array();
    $filters          = array();
    $tax_query        = array();
    $child_term_id    = array();
    $parent_term_name = array();
    $type_term_name     = array();

    //Query argugments for products filtering listing for pages
    //for differenct conditions
    $paged = ( isset( $_GET['_paged'] ) && $_GET['_paged'] ) ? intval( $_GET['_paged'] ) : 1;

    //default args
    $args = array(
        'post_type'      => 'geostone_product',
        'post_status'    => 'publish',
        'posts_per_page' => 20,
        'paged'          => intval( $paged ) ? intval( $paged ) : 1,
        'meta_key'       => 'volume',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    );

    //tax query args
    //user has interacted with drop down filters
    if ( isset( $_GET['do_filter'] ) && 'yes' == $_GET['do_filter'] ) {

        $filters['do_filter'] = 'yes';

        // state tax
        if ( isset( $_GET['_state'] ) && $_GET['_state'] ) {
            $tax_query[] = array(
                'taxonomy' => $geostone_taxonomy,
                'field'    => 'term_id',
                'terms'    => sanitize_text_field( $_GET['_state'] )
            );

            $filters['_state'] = $_GET['_state'];
        }

        // state tax for region
        if ( isset( $_GET['_region'] ) && $_GET['_region'] ) {
            $tax_query[] = array(
                'taxonomy' => $geostone_taxonomy,
                'field'    => 'term_id',
                'terms'    => sanitize_text_field( $_GET['_region'] )
            );

            $filters['_region'] = $_GET['_region'];
        }

        // state type
        if ( isset( $_GET['_type'] ) && $_GET['_type'] ) {
            $tax_query[] = array(
                'taxonomy' => $geostone_type_taxonomy,
                'field'    => 'term_id',
                'terms'    => sanitize_text_field( $_GET['_type'] )
            );

            $filters['_type'] = $_GET['_type'];
        }

    } //user has not interacted with drop down filters
    else {

        //user comes to similar product page from other page (user used dropdown filter)
        //tax query for state
        if ( isset( $_GET['pg_state'] ) && $_GET['pg_state'] && ! isset( $_GET['do_filter'] ) ) {
            $tax_query[] = array(
                'taxonomy' => $geostone_taxonomy,
                'field'    => 'term_id',
                'terms'    => sanitize_text_field( $_GET['pg_state'] )
            );

        }

        //user comes to similar product page from other page (user used dropdown filter)
        //tax query for regions
        if ( isset( $_GET['pg_region'] ) && $_GET['pg_region'] && ! isset( $_GET['do_filter'] ) ) {
            $tax_query[] = array(
                'taxonomy' => $geostone_taxonomy,
                'field'    => 'term_id',
                'terms'    => sanitize_text_field( $_GET['pg_region'] )
            );

        }
    }

    $stone_type = array();
    if ( get_field( 'list_by_product_range' ) != false && get_field( 'list_by_product_range' ) == 'Yes' ) {
        $stone_type  = get_field( 'product_range' );
        $tax_query[] = array(
            'taxonomy' => 'geostone_type',
            'field'    => 'term_id',
            'terms'    => $stone_type
        );

    }


    // add tax query to args
    if ( ! empty( $tax_query ) ) {
        $args['tax_query'] = $tax_query;
    }

    //echo '<pre>';print_r($tax_query);echo '</pre>';

    ?>

    <!-- Product dropdown filter section -->
    <section class="lister-module" id="product-listing-filter" <?php echo $style_bg; ?>>
        <div class="container">
            <!-- section title -->
            <h4 class="H4-Black-Center"><?php echo $section_title; ?></h4>

            <!-- current permalink value -->
            <input type="hidden" name="page_permalink" id="current-page-permalink" value="<?php the_permalink(); ?>">

            <div class="filter-row has-bg">
                <!-- filter options for state starts-->
                <div class="select-title">
                    Select your area
                </div>
                <ul class="selection-option-list select-state ignore">
                    <?php
                    $chosen_state    = '';
                    $state_triggered = '';
                    if ( $states ) {

                        //when product has only one region
                        //ignore even if user landed here from lister page with drop down filter selected
                        if ( 1 === count( $child_term_id ) ) {
                            $chosen_state    = "value=" . $parent_term_name[0]->term_id;
                            $state_triggered = "trigger"; ?>
                            <li class="changed" style=""><?php echo $parent_term_name[0]->name; ?></li>
                            <?php
                        }
                        //when product has multiple regions
                        //get state from lister page where drop down filter selected
                        elseif ( isset( $_GET['pg_state'] ) && $_GET['pg_state'] && ! isset( $_GET['do_filter'] ) ) {
                            $chosen_state    = "value=" . $_GET['pg_state'];
                            $state_triggered = "trigger";
                            ?>
                            <li class="changed" style=""><?php echo get_term( $_GET['pg_state'] )->name ?></li>
                            <?php
                        }
                        //when product has multiple regions
                        //user from lister page where drop down filter not selected
                        else {
                            $state_triggered = ''; ?>
                            <li class="changed" style="display: none;"></li>
                        <?php } ?>

                        <li class="always <?php echo $state_triggered; ?>"
                            data-tax="_state"><?php _e( 'Select State', 'geostone' ); ?></li>
                        <?php
                        foreach ( $states as $state ) {
                            $style = '';
                            // list parent state only
                            if ( 0 !== $state->parent ) {
                                continue;
                            }
                            if ( 1 === count( $parent_term_name ) && $parent_term_name[0]->term_id === $state->term_id ) {
                                $style = 'style="display: none;" class="temp"';
                            }
                            ?>
                            <li
                                    data-term_id="<?php echo esc_attr( $state->term_id ); ?>"
                                    data-tax="_state"
                                <?php echo $style; ?>
                            >
                                <?php echo $state->name; ?>
                            </li>
                        <?php } // end loop $states ?>

                    <?php } else { ?>
                        <li class="init"
                            data-tax="_state"><?php _e( 'State not available at the moment', 'geostone' ); ?></li>
                    <?php } ?>
                </ul>
                <input type="hidden" class="selected-tax" name="pg_state" <?php echo $chosen_state; ?> />

                <!-- filter options for state ends-->

                <!-- filter options for region starts -->
                <ul class="selection-option-list select-region ignore">
                    <?php
                    //when product has multiple regions
                    //get regions from lister page where drop down filter selected
                    $chosen_region = '';
                    if ( $child_term_id && 1 < count( $child_term_id ) ) {
                        ?>
                        <li class="changed" style="display: none;"></li>
                        <li class="always trigger"
                            data-tax="_region"><?php _e( 'Select Region', 'geostone' ); ?></li>
                        <?php foreach ( $child_term_id as $region ) { ?>
                            <li
                                    data-term_id="<?php echo esc_attr( $region->term_id ); ?>"
                                    data-tax="_region"
                            >
                                <?php echo $region->name; ?>
                            </li>
                        <?php } // end loop $child_term_id
                        ?>
                    <?php } //when product has single region
                    elseif ( $child_term_id && 1 === count( $child_term_id ) ) {
                        $chosen_region = "value=" . $child_term_id[0]->term_id;
                        ?>
                        <li class="changed" style=""><?php echo $child_term_id[0]->name; ?></li>
                    <?php } //when product has multiple regions and user land here by drop down filter selected
                    elseif ( isset( $_GET['pg_region'] ) && $_GET['pg_region'] ) {
                        $chosen_region = "value=" . $_GET['pg_region'];
                        ?>
                        <li class="changed" style=""><?php echo get_term( $_GET['pg_region'] )->name ?></li>
                        <li class="always trigger"
                            data-tax="_region"><?php _e( 'Select Region', 'geostone' ); ?></li>
                        <?php foreach ( $child_term_id as $region ) { ?>
                            <li
                                    data-term_id="<?php echo esc_attr( $region->term_id ); ?>"
                                    data-tax="_region"
                            >
                                <?php echo $region->name; ?>
                            </li>
                        <?php }
                    } //no region available
                    else { ?>
                        <li class="init"
                            data-tax="_region"><?php _e( 'Region not available at the moment', 'geostone' ); ?></li>
                    <?php } ?>
                </ul>
                <input type="hidden" class="selected-tax" name="pg_region" <?php echo $chosen_region; ?> />
                <!-- filter options for region ends -->

                <!-- filter options for type starts-->
                <div class="select-title">
                    Select product type
                </div>
                <ul class="selection-option-list select-type ignore">
                    <?php
                    $chosen_type    = '';
                    $type_triggered = '';
                    if ( $types ) {

                        //when product has only one type
                        if ( 1 === count( $type_term_name ) ) {
                            $chosen_type    = "value=" . $type_term_name[0]->term_id;
                            $type_triggered = "trigger"; ?>
                            <li class="changed" style=""><?php echo $type_term_name[0]->name; ?></li>
                            <?php
                        }
                        //when product has multiple types
                        elseif ( isset( $_GET['pg_type'] ) && $_GET['pg_type'] && ! isset( $_GET['do_filter'] ) ) {
                            $chosen_type    = "value=" . $_GET['pg_type'];
                            $type_triggered = "trigger";
                            ?>
                            <li class="changed" style=""><?php echo get_term( $_GET['pg_type'] )->name ?></li>
                            <?php
                        }
                        //when product has multiple types and user has not selected
                        else {
                            $type_triggered = ''; ?>
                            <li class="changed" style="display: none;"></li>
                        <?php } ?>

                        <li class="always <?php echo $type_triggered; ?>"
                            data-tax="_type"><?php _e( 'Select Type', 'geostone' ); ?></li>
                        <?php
                        foreach ( $types as $type ) {
                            $style = '';
                            ?>
                            <li
                                    data-term_id="<?php echo esc_attr( $type->term_id ); ?>"
                                    data-tax="_type"
                                <?php echo $style; ?>
                            >
                                <?php echo $type->name; ?>
                            </li>
                        <?php } // end loop $types ?>

                    <?php } else { ?>
                        <li class="init"
                            data-tax="_type"><?php _e( 'Type not available at the moment', 'geostone' ); ?></li>
                    <?php } ?>
                </ul>
                <input type="hidden" class="selected-tax" name="pg_type" <?php echo $chosen_type; ?> />

                <!-- filter options for type ends-->
            </div>
        </div>
    </section>
    <!-- Product dropdown filter section end -->

    <!-- Product listing section -->
    <section class="lister-module product-lister-section">
        <div class="container">
            <?php if ( get_field( 'section_description' ) ) { ?>
                <p class="description"><?php the_field( 'section_description' ); ?></p>
            <?php } ?>
            <!-- List of products -->
            <ul class="products-list" id="products-list">
                <?php
                //Get products
                $wp_query = new WP_Query( $args );

                if ( $wp_query->have_posts() ) {
                    while ( $wp_query->have_posts() ) {
                        $wp_query->the_post();
                        get_template_part( 'template-parts/geostone', 'products-loop' );
                    }
                } else { ?>
                    <li class="no-products-found">
                        <div class="no-product-icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/dist/assets/icons/product-not-found.svg"
                                 alt="No Product Found">
                        </div>
                        <p class="no-product-text"><?php _e( 'No Products Found!', 'geostone' ); ?></p>
                    </li>
                <?php }
                wp_reset_query();
                ?>
            </ul>
            <!-- List of products ends -->

            <!-- Pagination -->
            <?php get_template_part( 'template-parts/geostone', 'pagination' ); ?>
            <!-- Pagination ends -->
        </div>
    </section>
    <!-- Product listing section ends -->
<?php } ?>
