<?php
// Template Name: Отзывы

use App\Services\WP_Vk;
use Timber\Helper;

$context = \Timber\Timber::context();

$context['breadcrumbs'] = generate_crumbs();

$context['post'] = \Timber\Timber::get_post(get_queried_object_id());


//var_dump($context['post'] );
//$context['reviews'] = WP_Vk::getVKReviews();

Timber::render('page-reviews.twig', $context);

//WP_Vk::getVKReviews();
