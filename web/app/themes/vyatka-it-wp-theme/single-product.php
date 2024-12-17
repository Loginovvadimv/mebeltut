<?php
$context = \Timber\Timber::context();

$context['breadcrumbs'] = generate_crumbs([
    //'parent' => get_post(6)
]);

$context['post'] = \Timber\Timber::get_post(get_queried_object_id());

Timber::render('single-product.twig', $context);
