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


function generate_filters($category = null)
{
    $filters = [];

    // Формируем массивы для выборки самого дешевого и самого дорогого товара
    $min_price_posts_args = [
        'ignore_custom_sort' => true,
        'post_type' => 'product',
        'meta_key' => 'price',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'numberposts' => 1
    ];

    $max_price_posts_args = [
        'ignore_custom_sort' => true,
        'post_type' => 'product',
        'meta_key' => 'price',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'numberposts' => 1
    ];

    // Если в аргумент передадим объект категории то применяем фильтрацию по этим категориям
    if ($category) {
        $min_price_posts_args['tax_query'] = [
            [
                'taxonomy' => 'categories-products',
                'field' => 'term_id',
                'terms' => $category->term_id
            ]
        ];
        $max_price_posts_args['tax_query'] = [
            [
                'taxonomy' => 'categories-products',
                'field' => 'term_id',
                'terms' => $category->term_id
            ]
        ];
    }

    // Выбираем эти товары (дешевые/дорогие)
    $min_price_posts = get_posts($min_price_posts_args);
    $max_price_posts = get_posts($max_price_posts_args);

    // Формируем массив с возможными ценами на основе выборки выше
    if ($min_price_posts && $max_price_posts) {
        $min_price = get_field('price', $min_price_posts[0]->ID);
        $max_price = get_field('price', $max_price_posts[0]->ID);

        $filters['price'] = [
            'min' => $min_price,
            'min_current' => !empty($_GET['price']['min']) ? $_GET['price']['min'] : $min_price,
            'max' => $max_price,
            'max_current' => !empty($_GET['price']['max']) ? $_GET['price']['max'] : $max_price,
        ];
    }

    // Получение объекта ACF поля со всеми его настройками и значениями
    $style = get_field_object('field_6784eedc5522a'); // Стиль

    if ($style) {
        // Формируем новый массив значений на основе значений из ACF поля
        $values = get_attribute_values($style['name'], $style['choices']);

        // Заносим в массив название поля, его код и новые значения
        $filters['auto']['styles'] = [
            'name' => $style['label'],
            'code' => $style['name'],
            'values' => $values,
        ];
    }

    $material = get_field_object('field_6784efe275711'); // Материал

    if ($material) {
        // Формируем новый массив значений на основе значений из ACF поля
        $values = get_attribute_values($material['name'], $material['choices']);

        // Заносим в массив название поля, его код и новые значения
        $filters['auto']['material'] = [
            'name' => $material['label'],
            'code' => $material['name'],
            'values' => $values,
        ];
    }

    $fasade = get_field_object('field_6784f11db828f'); // Фасад

    if ($fasade) {
        // Формируем новый массив значений на основе значений из ACF поля
        $values = get_attribute_values($fasade['name'], $fasade['choices']);

        // Заносим в массив название поля, его код и новые значения
        $filters['auto']['fasade'] = [
            'name' => $fasade['label'],
            'code' => $fasade['name'],
            'values' => $values,
        ];
    }


    return $filters;
}

function get_attribute_values($attribute_name, $values)
{
    $data = [];

    // Идем по каждому значению и добавляем его в массив зачений
    foreach ($values as $choice) {
        // Проверяем есть ли данное значение в $_GET параметрах, функция вернет true если есть
        $active = check_attribute_in_parameters($attribute_name, $choice);

        $data[] = [
            'value' => $choice,
            'checked' => $active
        ];
    }

    return $data;
}

function check_attribute_in_parameters($attribute, $value)
{
    // Проверяем есть ли какие либо аттрибуты и есть ли в этих аттрибутах нужный нам аттрибут
    if (!empty($_GET['attribute']) && !empty($_GET['attribute'][$attribute])) {
        // Вернет true если указанное значение есть в аттрибуте из $_GET параметров
        return in_array($value, $_GET['attribute'][$attribute]);
    }

    return false;
}

function apply_product_sort($args)
{
    if (isset($_GET['sort']) && !empty($_GET['sort'])) {
        $parts = explode('_', $_GET['sort']);

        if ('price' === $parts[0]) {
            $args['orderby'] = [
                'price' => $parts[1],
            ];

            if (!empty($args['meta_query'])) {
                $args['meta_query']['price'] = [
                    'key' => 'price',
                    'type' => 'NUMERIC',
                    'compare' => 'EXISTS'
                ];
            } else {
                $args['meta_query'] = [
                    'price' => [
                        'key' => 'price',
                        'type' => 'NUMERIC',
                        'compare' => 'EXISTS'
                    ]
                ];
            }
        } else {
            $args['orderby'] = 'meta_value';
            $args['order'] = $parts[1];
            $args['meta_key'] = $parts[0];
        }
    }

    return $args;
}

function apply_product_filter($args)
{
    $defaultPerPage = POSTS_PER_PAGE_PRODUCT;

    // Проверяем есть ли аттрибуты в $_GET параметрах
    if (!empty($_GET['attribute'])) {
        // Проходимаем по каждому аттрибуту и добавляем его в массив с фильтрами
        foreach ($_GET['attribute'] as $key => $value) {
            $args['meta_query'][] = [
                [
                    'key'   => $key,
                    'value' => $value,
                ]
            ];
        }
    }

    // Проверяем есть ли цена в $_GET параметрах
    if (!empty($_GET['price'])) {
        // Добавляем фильтр по цене, делаем вариант "Между двумя значениями"
        $args['meta_query'][] = [
            [
                'key'     => 'price',
                'value'   => [
                    $_GET['price']['min'],
                    $_GET['price']['max'],
                ],
                'type'    => 'numeric',
                'compare' => 'BETWEEN',
            ]
        ];
    }
    if (!empty($_GET['post_page'])) {
        // Добавляем фильтр по цене, делаем вариант "Между двумя значениями"
        $args['posts_per_page'] = $_GET['post_page']*$defaultPerPage;
    } else {
        $args['posts_per_page'] =$defaultPerPage;
    }

    return $args;
}

function format_price($price)
{
    return number_format($price, 0, '.', ' ');
}
