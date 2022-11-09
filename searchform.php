<form role="search" method="get" class="search-form" action="<?php echo get_home_url( '/' ); ?>">
    <label class="visually-hidden"><?php echo _x( 'Search for:', 'customtemplate' ) ?></label>
    <div class="d-flex">
        <div class="form-item flex-grow-1">
            <input type="search" class="form-control" placeholder="<?php echo esc_attr_x( 'Search...', 'customtemplate' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-search"><span class="bi bi-search"></span></button>
        </div>
    </div>
</form>