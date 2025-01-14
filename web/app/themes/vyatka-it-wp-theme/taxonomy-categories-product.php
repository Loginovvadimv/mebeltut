<?php
use Timber\Helper;

$context = \Timber\Timber::context();

if (!isset($paged) || !$paged) {
    $paged = 1;
}

$object = get_queried_object();

$context['breadcrumbs'] = generate_crumbs();

//// Формируем массив запроса за товарами
//$args = [
//    'post_type' => 'product',
//    'meta_query' => []
//];
//
//// Модифицируем этот массив функцией, котрая добавит фильтрацию на основе $_GET параметров
//$args = apply_product_filter($args);
//
//
//
//// Получаем товары передав в функцию get_posts сформированный массив запроса
//$new_args = $args;
//unset($new_args['posts_per_page']);
//$totalCount = Timber::get_posts($new_args);
//
//$url = parse_url($_SERVER['REQUEST_URI']);
////var_dump($url['query']);
////var_dump($url);
//$newQuery = [];
//if (isset($url['query']) && $url['query'] != ''){
//    foreach (explode('&', $url['query']) as $param) {
//        $param = explode('=', $param);
//        $newQuery[$param[0]] = $param[1];
//    }
//}
//
//if (isset($newQuery['post_page'])){
//    $newQuery['post_page'] = $newQuery['post_page']+1;
//}else{
//    $newQuery['post_page'] = 2;
//}
//$newUrl = $url['path'] . '?' . http_build_query($newQuery);
//
//$context['products'] = Timber::get_posts($args);
//$context['totalCountPosts'] = count($totalCount);
//$context['nextPage'] = $newUrl;







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

//$context['totalCountPosts'] = count($totalCount);

// Получаем товары передав в функцию get_posts сформированный массив запроса
$context['posts'] = Timber::get_posts($args);

Timber::render('page-allProducts.twig', $context);
