<?php
// Template Name: Гарантия и доставка

use Timber\Helper;

$context = \Timber\Timber::context();

$context['breadcrumbs'] = generate_crumbs();

Timber::render('page-garanty.twig', $context);
