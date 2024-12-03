<?php

use App\System\Webp;

if (!function_exists('generate_crumbs')) {
    function generate_crumbs($data = null): array
    {
        $breadcrumbs = [];

        $object = get_queried_object();

        $breadcrumbs[] = [
            'name' => 'Главная',
            'href' => '/'
        ];

        if (isset($data['parent'])) {
            $parent = $data['parent'];

            $name = $parent->post_title ?? $parent->term_id;

            $href =
                isset($parent->ID)
                    ? get_permalink($parent->ID)
                    : (
                isset($parent->term_id)
                    ? get_term_link($parent)
                    : ''
                );

            $breadcrumbs[] = [
                'name' => $name,
                'href' => $href
            ];
        }

        if (isset($object->post_parent) && $object->post_parent != 0) {
            $parent = get_post($object->post_parent);

            $breadcrumbs[] = [
                'last' => false,
                'name' => $parent->post_title,
                'href' => get_permalink($object->post_parent)
            ];
        }

        if (isset($object->ID)) {
            $terms = [];
            $taxonomies = get_taxonomies();

            foreach ($taxonomies as $taxonomy) {
                if ($taxonomy !== 'product_cat') continue;

                $taxonomy_terms = wp_get_post_terms($object->ID, $taxonomy);

                if (!empty($taxonomy_terms)) {
                    $taxonomy_term = $taxonomy_terms[0];
                    $taxonomy_parent_id = wp_get_term_taxonomy_parent_id($taxonomy_term->term_id, $taxonomy_term->taxonomy);
                    $taxonomy_parent = get_term($taxonomy_parent_id, $taxonomy_term->taxonomy);

                    if (!empty($taxonomy_parent) && isset($taxonomy_parent->error)) {
                        $breadcrumbs[] = [
                            'last' => false,
                            'name' => $taxonomy_parent->name,
                            'href' => get_term_link($taxonomy_parent->term_id)
                        ];
                    }

                    $breadcrumbs[] = [
                        'last' => false,
                        'name' => $taxonomy_term->name,
                        'href' => get_term_link($taxonomy_term->term_id)
                    ];
                }
            }

            $breadcrumbs[] = [
                'last' => true,
                'name' => $object->post_title,
                'href' => ''
            ];
        } else if (isset($object->term_id)) {
            $breadcrumbs[] = [
                'last' => true,
                'name' => $object->name,
                'href' => ''
            ];
        } else if (isset($object->has_archive) && $object->has_archive) {
            $breadcrumbs[] = [
                'last' => true,
                'name' => $object->label,
                'href' => ''
            ];
        }

        return $breadcrumbs;
    }
}

if (!function_exists('get_term_path')) {
    function get_term_path($term)
    {
    }
}

if (!function_exists('only_num')) {
    function only_num($string)
    {
        return preg_replace("/[^0-9]/", '', $string);
    }
}


if (!function_exists('webp')) {
    function webp($post_id, $size = 'full')
    {
        return Webp::image($post_id, $size);
    }
}

function getTaxonomyList($rootid)
{
    $data = [];

    $terms = Timber::get_terms([
        'taxonomy' => 'product_cat',
        'parent' => $rootid,
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => false,
    ]);

    foreach ($terms as $term) {

        $data[$term->term_id] = [
            'term_id' => $term->term_id,
            'name'      => $term->name,
            'link'      => $term->link,
            'children'  => [],
        ];

        $childTerms = Timber::get_terms([
            'taxonomy' => 'product_cat',
            'child_of' => $term->term_id,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => false,
        ]);

        foreach ($childTerms as $childTerm) {

            $data[$term->term_id]['children'][$childTerm->term_id] = [
                'term_id' => $childTerm->term_id,
                'name' => $childTerm->name,
                'link' => $childTerm->link,
            ];

            //$query = new WP_Query([
            //    'cat' => $childTerm->term_id,
            //    'orderby' => 'title',
            //    'order' => 'ASC',
            //    'posts_per_page' => -1,
            //]);
            //
            //while ($query->have_posts()) {
            //    $query->the_post();
            //    $data[$term->term_id]['children'][$childTerm->term_id]['posts'][] = [
            //        'url'   => get_the_permalink(),
            //        'title' => get_the_title(),
            //    ];
            //}
            //wp_reset_postdata();
        }
    }
    return $data;
}

function display_category_image($category)
{
    $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);

    //$image = wp_get_attachment_url($thumbnail_id);
    //if ($image) {
    //    echo '<img src="' . $image . '" alt="' . $category->name . '" />';
    //}
}
