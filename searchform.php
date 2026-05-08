<?php
/**
 * Pi Dentist — Search Form
 */
defined( 'ABSPATH' ) || exit;
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text">Tìm kiếm:</span>
        <input type="search" class="search-field" placeholder="Tìm kiếm..." value="<?php echo get_search_query(); ?>" name="s" />
    </label>
    <button type="submit" class="search-submit btn btn-gold" aria-label="Tìm kiếm">Tìm</button>
</form>
