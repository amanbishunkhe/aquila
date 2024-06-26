<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <div class="container-fluid">
      <?php
        if( function_exists('the_custom_logo') ){
          the_custom_logo();
        }    

        use AQUILA_THEME\Inc\Menus;
        $menu_class = Menus::get_instance();
        $header_menu_id = $menu_class->get_menu_id_from_location('header-menu');

        $header_menus = wp_get_nav_menu_items( $header_menu_id );
      ?>
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php if( !empty( $header_menus ) && is_array( $header_menus ) ): ?>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php
          foreach ($header_menus as $menu_item) {
            if( ! $menu_item->menu_item_parent ):

              $parent_menu_id = $menu_item->ID;
              $child_menu_items = $menu_class->get_child_menu_items( $header_menus, $parent_menu_id );
              $has_children = !empty( $child_menu_items ) && is_array( $child_menu_items );

              // Check if the current menu item is active
              $active_class = ( $menu_item->object_id == get_the_ID() ) ? 'current' : '';

              if( !$has_children ){
                ?>
                <li class="nav-item <?php echo $active_class; ?>">
                  <a class="nav-link" href="<?php echo esc_url( $menu_item->url ); ?>"><?php echo esc_html( $menu_item->title ); ?></a>
                </li>
                <?php
              } else {
                
                ?>
                <li class="nav-item first dropdown <?php echo $active_class; ?>">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo esc_html( $menu_item->title ); ?>
                  </a>
                  
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <?php
                    foreach ($child_menu_items as $key => $child_menu_item) {
                      // Check if the current child menu item is active
                      $child_active_class = ( $child_menu_item->object_id == get_the_ID() ) ? 'current' : '';
                      ?>
                      <a class="dropdown-item <?php echo $child_active_class; ?>" href="<?php echo esc_url( $child_menu_item->url ); ?>"><?php echo esc_html( $child_menu_item->title ); ?></a>
                      <?php
                    }
                    ?>                                 
                  </div>
                </li>
                <?php
              }
            endif;  
          }  
          ?>
        </ul>
        <?php endif; ?>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>
</nav>
