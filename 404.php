<?php
/**
 * Pi Dentist — 404 Page
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="primary" class="site-main" role="main">
    <section class="error-404">
        <div class="container">
            <h1>404 — Trang không tồn tại</h1>
            <p>Xin lỗi, trang bạn tìm kiếm không tồn tại hoặc đã được di chuyển.</p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-gold">Về trang chủ</a>
        </div>
    </section>
</main>

<?php
get_footer();
