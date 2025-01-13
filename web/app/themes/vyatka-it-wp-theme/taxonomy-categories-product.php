<?php
use Timber\Helper;

$context = \Timber\Timber::context();

if (!isset($paged) || !$paged) {
    $paged = 1;
}

$object = get_queried_object();

$context['breadcrumbs'] = generate_crumbs();

// Формируем массив с фильтрами
$context['filters'] = generate_filters();

// Формируем массив запроса за товарами
$args = [
    'post_type' => 'product',
    'meta_query' => [],
    'tax_query' => [
        [
            'taxonomy' => 'categories-product',
            'field' => 'term_id',
            'terms' => $object->term_id
        ]
    ]
];

// Модифицируем этот массив функцией, котрая добавит фильтрацию на основе $_GET параметров
$args = apply_product_filter($args);
$args = apply_product_sort($args);

// Получаем товары передав в функцию get_posts сформированный массив запроса
$context['posts'] = Timber::get_posts($args);

Timber::render('page-allProducts.twig', $context);
