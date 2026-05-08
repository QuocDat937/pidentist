<?php
/**
 * Pi Dentist — 404 Page
 *
 * Trang lỗi 404 — Trang không tồn tại.
 * Design: Navy background, big π symbol, search form, CTA home.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main class="pi-404" id="main-content">
	<section class="pi-404__section">
		<div class="container">
			<div class="pi-404__content">

				<div class="pi-404__symbol" aria-hidden="true">π</div>

				<h1 class="pi-404__heading">Trang không tồn tại</h1>

				<p class="pi-404__text">
					Xin lỗi, trang bạn tìm không có hoặc đã được di chuyển.<br>
					Vui lòng thử tìm kiếm hoặc quay về trang chủ.
				</p>

				<div class="pi-404__search">
					<?php get_search_form(); ?>
				</div>

				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-gold">
					Về trang chủ
				</a>

			</div>
		</div>
	</section>
</main>

<?php get_footer();
