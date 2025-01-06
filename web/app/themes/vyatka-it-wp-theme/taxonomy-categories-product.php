<?php
use Timber\Helper;

$context = \Timber\Timber::context();

if (!isset($paged) || !$paged) {
    $paged = 1;
}

$context['breadcrumbs'] = generate_crumbs();


$context['posts'] = Timber::get_posts([
    'post_type' => 'category.posts',
    'posts_per_page' => '1',
    'paged' => $paged
]);

Timber::render('page-allProducts.twig', $context);
