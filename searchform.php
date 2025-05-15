<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="s">
        <span class="screen-reader-text"><?php echo _x('Search for:', 'label', 'your-theme-textdomain'); ?></span>
    </label>
    <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'your-theme-textdomain'); ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" />
    <button type="submit" class="search-submit">
        <i class="fas fa-search"></i>
    </button>
</form>