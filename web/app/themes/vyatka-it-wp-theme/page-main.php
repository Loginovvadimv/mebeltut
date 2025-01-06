<?php
// Template Name: Главная
use App\Services\WP_Review;
use Timber\Timber;

$context = Timber::context();
$context['main_screen'] = get_field('main-screen', 'options');

$context['products'] = Timber::get_posts([
    'post_type' => 'product',
]);

//$context['categories_proj'] = Timber::get_terms([
//    'taxonomy' => 'categories-project',
//    'orderby' => 'id',
//    'order' => 'ASC',
//    'parent' => 0,
//    'hide_empty' => false,
//]);

$context['posts'] = Timber::get_posts([
    'post_type' => 'project',
    'posts_per_page' => '-1'
]);



Timber::render('page-main.twig', $context);
