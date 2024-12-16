<?php
// Template Name: Как заказать

use Timber\Helper;

$context = \Timber\Timber::context();

$context['breadcrumbs'] = generate_crumbs();

Timber::render('page-howToOrder.twig', $context);
