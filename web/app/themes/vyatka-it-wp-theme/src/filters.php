<?php
use App\Resources\Service;
use App\Services\WP_Vk;

// Global Context
add_filter('timber/context', function ($context) {
    $context[ 'assets' ] = ASSETS;
    $context[ 'requisits' ] = get_field('requisits', 'options');
    $context[ 'phone' ] = get_field('phone', 'options');
    $context[ 'phone2' ] = get_field('phone2', 'options');
    $context[ 'cleared_phone' ] = only_num(get_field('phone', 'options'));
    $context[ 'cleared_phone2' ] = only_num(get_field('phone2', 'options'));
    $context[ 'email' ] = get_field('email', 'options');
    $context[ 'address' ] = get_field('address', 'options');
    $context[ 'worktime' ] = get_field('worktime', 'options');
    $context[ 'tg' ] = get_field('tg', 'options');
    $context[ 'yt' ] = get_field('yt', 'options');
    $context[ 'wa' ] = get_field('wa', 'options');
    $context[ 'vk' ] = get_field('vk', 'options');
    $context[ 'ig' ] = get_field('ig', 'options');
    $context[ 'main_menu' ] = Timber::get_menu('header-menu');
    $context[ 'footer_menu' ] = Timber::get_menu('footer-menu');
    $context[ 'main_page' ] = get_home_url();
    $context[ 'header_code' ] = get_field('header_code', 'options');
    $context[ 'footer_code' ] = get_field('footer_code', 'options');
    $context['plug_url'] = ASSETS . '/images/plug.webp';
    $context['plug_client'] = ASSETS . '/images/plug_client.webp';
    $context['calculation'] = get_field('calculation', 'options');
    $context['vk_groupe'] = get_field('vk_groupe', 'options');
    $context['howorder'] = get_field('howorder', 'options');
//    $context['reviews'] = get_field('reviews', 'options');
    $context['reviews'] = WP_Vk::getVKReviews();

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

    $total_posts = \Timber\Timber::get_posts([
        'post_type' => 'project',
        'posts_per_page' => -1
    ])->count();

    $context['total_posts'] = $total_posts;

    return $context;
});




// Custom PostType
add_filter('timber/post/classmap', function ($classmap) {
    $custom_classmap = [
        'service' => Service::class,
    ];

    return array_merge($classmap, $custom_classmap);
});



