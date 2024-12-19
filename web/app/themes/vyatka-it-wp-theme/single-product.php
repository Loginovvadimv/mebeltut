<?php
$context = \Timber\Timber::context();

$context['breadcrumbs'] = generate_crumbs([
    //'parent' => get_post(6)
]);

$context['post'] = \Timber\Timber::get_post(get_queried_object_id());

$context['workprogress'] = get_field('workprogress', 'options');

$context['categories_feat'] = Timber::get_terms([
    'taxonomy' => 'categories-feature',
    'orderby' => 'id',
    'order' => 'ASC',
    'parent' => 0,
    'hide_empty' => false,
]);

Timber::render('single-product.twig', $context);
