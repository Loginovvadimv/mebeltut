<?php
// Template Name: Наши проекты с реальными фото

use Timber\Helper;

$context = \Timber\Timber::context();

$context['breadcrumbs'] = generate_crumbs();

//$context['categories_proj'] = Timber::get_terms([
//    'taxonomy' => 'categories-project',
//    'orderby' => 'id',
//    'order' => 'ASC',
//    'parent' => 0,
//    'hide_empty' => false,
//]);

Timber::render('page-allProjects.twig', $context);
