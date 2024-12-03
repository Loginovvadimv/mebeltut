<?php

namespace App\Services;

use Timber\Timber;
use WP_REST_Request;

class WP_Filter {
    public function generateFilters($post_type, $term) {
        $filters = [];

        $all_posts = \Timber::get_posts([
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'tax_query' => [
                [
                    'taxonomy' => $term->taxonomy,
                    'field' => 'term_id',
                    'terms' => $term->term_id
                ]
            ]
        ]);

        $parameters_raw = get_field_object('field_65fd600799639');

        foreach ($all_posts as $post) {
            $parameters = $post->meta('parameters');

            if (is_array($parameters)) {
                foreach ($parameters as $parameter_key => $parameter) {
                    if (empty($parameter)) {
                        continue;
                    }

                    //if (!$parameter['in_filter']) {
                    //    continue;
                    //}

                    if ($parameters_raw) {
                        if (!isset($filters[$parameter_key])) {
                            $parameter_raw_key = array_search($parameter_key, array_column($parameters_raw['sub_fields'], 'name'));
                            $parameter_label = $parameters_raw['sub_fields'][$parameter_raw_key]['label'];

                            $filters[$parameter_key] = [
                                'name' => $parameter_key,
                                'label' => $parameter_label,
                                'values' => []
                            ];
                        }

                        if (!in_array($parameter, $filters[$parameter_key]['values'])) {
                            $filters[$parameter_key]['values'][] = $parameter;
                        }
                    }
                }
            }
        }

        return $filters;
    }

    public function applyFilter(WP_REST_Request $request)
    {
        $filter = $request->get_param('filter');
        $post_type = $request->get_param('post_type');
        $taxonomy = $request->get_param('taxonomy');
        $term_id = $request->get_param('term_id');
        $return = [];

        $arguments = [
            'post_type' => $post_type,
            'posts_per_page' => 6,
            'tax_query' => [
                [
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $term_id
                ]
            ]
        ];

        if ($filter) {
            $arguments = $this->filtering($arguments, $filter);
        }

        $posts = Timber::get_posts($arguments);

        if ($posts) {
            $term = Timber::get_term($term_id);

            $return['posts'] = '';

            $pagination = $posts->pagination();

            foreach ($pagination->pages as $key => $page) {
                if (isset($page['link'])) {
                    $pagination->pages[$key]['link'] = pagination_taxonomy_url_fix($page['link'], get_term_link($term));
                }
            }

            $return['pagination'] = Timber::compile('parts/pagination.twig', ['pagination' => $posts->pagination()]);;

            foreach ($posts as $post) {
                $return['posts'] .= Timber::compile('parts/project-card.twig', ['post' => $post]);
            }
        }

        return $return;
    }

    public function filtering(array $arguments, $filters): array
    {
        $arguments['meta_query']['relation'] = 'AND';

        foreach ($filters as $filter_key => $filter) {
            $meta_query_by_values = [
                'relation' => 'OR'
            ];

            if (is_array($filter)) {
                foreach ($filter as $value) {
                    $meta_query_by_values[] = [
                        'key' => 'parameters_' . $filter_key,
                        'compare' => '=',
                        'value' => $value,
                    ];
                }
            }

            $meta_query = $meta_query_by_values;

            $arguments['meta_query'][] = $meta_query;
        }

        return $arguments;
    }
}