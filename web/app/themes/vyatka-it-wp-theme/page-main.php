<?php
// Template Name: Главная
use App\Services\WP_Review;
use Timber\Timber;

$context = Timber::context();
$context['main_screen'] = get_field('main-screen', 'options');
//$context['comments'] = WP_Review::get();
$context['vk_groupe'] = get_field('vk_groupe', 'options');
$context['reviews'] = get_field('reviews', 'options');

$context['products'] = Timber::get_posts([
    'post_type' => 'product',
]);

$context['categories_prod'] = Timber::get_terms([
    'taxonomy' => 'categories-product',
    'orderby' => 'id',
    'order' => 'ASC',
    'parent' => 0,
    'hide_empty' => false
]);

$context['categories_proj'] = Timber::get_terms([
    'taxonomy' => 'categories-project',
    'orderby' => 'id',
    'order' => 'ASC',
    'parent' => 0,
    'hide_empty' => false,
]);

$context['posts'] = Timber::get_posts([
    'post_type' => 'categories_proj',
    'posts_per_page' => '-1'
]);

//function calculateDiscount($total_price, $new_price) {
//    $discount = ($total_price - $new_price) / $total_price * 100;
//    return $discount;
//}
//
//$discount = calculateDiscount($total_price, $new_price);
//
//echo "Discount: " . $discount . "%"; // Output: Discount: 30%


Timber::render('page-main.twig', $context);
