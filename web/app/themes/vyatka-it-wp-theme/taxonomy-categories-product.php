<?php
use Timber\Helper;

$context = \Timber\Timber::context();

$context['breadcrumbs'] = generate_crumbs();


Timber::render('page-allProducts.twig', $context);
