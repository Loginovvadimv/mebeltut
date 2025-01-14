<?php
// Template Name: Главная
use App\Services\WP_Review;
use Timber\Timber;

$context = Timber::context();
$context['main_screen'] = get_field('main-screen', 'options');

$context['products'] = Timber::get_posts([
    'post_type' => 'product',
]);

$context['posts'] = Timber::get_posts([
    'post_type' => 'project',
    'posts_per_page' => '-1'
]);



Timber::render('page-main.twig', $context);
