<?php
// Template Name: О нас

use Timber\Helper;

$context = \Timber\Timber::context();

$context['breadcrumbs'] = generate_crumbs();

Timber::render('page-forus.twig', $context);
