<?php
/**
 * Pi Dentist — Pattern Categories
 *
 * Đăng ký các block pattern category riêng cho Pi Dentist.
 * Ẩn remote patterns mặc định của WordPress.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern_category( 'pi-homepage', [
        'label'       => 'Pi Dentist - Homepage',
        'description' => 'Các sections của trang chủ Pi Dentist',
    ] );
    register_block_pattern_category( 'pi-sections', [
        'label'       => 'Pi Dentist - Sections',
        'description' => 'Các block section dùng cho trang con',
    ] );
    register_block_pattern_category( 'pi-cta', [
        'label'       => 'Pi Dentist - CTA',
        'description' => 'Khối Call-to-Action',
    ] );
});

// Ẩn các pattern category mặc định (remote) của WP cho gọn
add_filter( 'should_load_remote_block_patterns', '__return_false' );
