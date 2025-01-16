<?php
// Template Name: Наши проекты с реальными фото

use Timber\Helper;

$context = \Timber\Timber::context();

if (!isset($paged) || !$paged) {
    $paged = 1;
}

$context['breadcrumbs'] = generate_crumbs();

$object = get_queried_object();
//
 //Формируем массив запроса за товарами
$args = [
    'post_type' => 'project',
    'posts_per_page' => POSTS_PER_PAGE_PROJECT,
    'paged' => $paged,
    'meta_query' => [],
];

// Модифицируем этот массив функцией, котрая добавит фильтрацию на основе $_GET параметров
$args = apply_product_filter($args);
$args = apply_product_sort($args);

// Получаем товары передав в функцию get_posts сформированный массив запроса
$context['posts'] = Timber::get_posts($args);

$context['posts']->pagination([
    'end_size' => 1,
    'mid_size' => 1
]);

Timber::render('page-allProjects.twig', $context);
