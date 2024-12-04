<?php
// Template Name: Главная
use App\Services\WP_Review;
use Timber\Timber;

$context = Timber::context();
$context['main_screen'] = get_field('main-screen', 'options');
$context['comments'] = WP_Review::get();
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


Timber::render('page-main.twig', $context);
