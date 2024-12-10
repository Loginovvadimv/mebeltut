<?php
use App\Resources\Service;

// Global Context
add_filter('timber/context', function ($context) {
    $context[ 'assets' ] = ASSETS;
    $context[ 'phone' ] = get_field('phone', 'options');
    $context[ 'cleared_phone' ] = only_num(get_field('phone', 'options'));
    $context[ 'email' ] = get_field('email', 'options');
    $context[ 'address' ] = get_field('address', 'options');
    $context[ 'worktime' ] = get_field('worktime', 'options');
    $context[ 'tg' ] = get_field('tg', 'options');
    $context[ 'yt' ] = get_field('yt', 'options');
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

    return $context;
});

// Custom PostType
add_filter('timber/post/classmap', function ($classmap) {
    $custom_classmap = [
        'service' => Service::class,
    ];

    return array_merge($classmap, $custom_classmap);
});



