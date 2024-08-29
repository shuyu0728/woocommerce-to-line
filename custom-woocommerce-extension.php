<?php
/*
Plugin Name: Custom WooCommerce Extension
Description: A custom plugin to add products directly to the WooCommerce cart from LINE.
Version: 1.0
Author: Your Name
*/

// 確保直接訪問此文件時安全
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// 自定義函數來將產品添加到購物車
function add_product_to_cart_via_line($user_id, $product_id) {
    // 在這裡編寫代碼來將產品添加到購物車
    WC()->cart->add_to_cart($product_id, 1);
}

// 用於接收 LINE Webhook 的自定義鉤子（你需要設置這個鉤子來處理 LINE 請求）
add_action('wp_ajax_nopriv_add_product_to_cart', 'handle_line_request');
add_action('wp_ajax_add_product_to_cart', 'handle_line_request');

function handle_line_request() {
    // 在這裡接收來自 LINE 的數據，並調用 add_product_to_cart_via_line 函數
    $user_id = sanitize_text_field($_POST['user_id']);
    $product_id = intval($_POST['product_id']);

    if ($user_id && $product_id) {
        add_product_to_cart_via_line($user_id, $product_id);
        wp_send_json_success('Product added to cart');
    } else {
        wp_send_json_error('Invalid data');
    }

    wp_die(); // 結束 AJAX 請求
}

