<?php
// Template Name: Наши проекты с реальными фото

use Timber\Helper;

$context = \Timber\Timber::context();

$context['breadcrumbs'] = generate_crumbs();

Timber::render('page-allProjects.twig', $context);
