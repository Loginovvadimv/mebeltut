<?php
// Template Name: Контакты

use Timber\Helper;

$context = \Timber\Timber::context();

$context['breadcrumbs'] = generate_crumbs();

Timber::render('page-contacts.twig', $context);
