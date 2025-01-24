<?php


class TableImporter
{

    private $file = 'test.csv';
    private $delimiter = ';';
    private $data = null;
    private $taxonomy = 'categories-product';

    public function __construct()
    {
        $this->updateChainsHook();
    }

    public function updateChainsHook()
    {

        $cats = $this->updateTaxonomies();
        $this->updateProducts($cats);
    }//ok

    private function readExcelFile()
    {
        if ($this->data) {
            return $this->data;
        }
        $this->data = [];
        $row = 0;
        if (($handle = fopen($this->file, "r")) !== FALSE) {
            while (($dataFile = fgetcsv($handle, 5000, $this->delimiter)) !== FALSE) {
                $num = count($dataFile);
                if ($row == 0) {
                    $row++;
                    continue;
                }
                for ($c = 0; $c < $num; $c++) {
                    $this->data[$row][$c] = $dataFile[$c];
                }
                $row++;
            }

            fclose($handle);
        }
        return $this->data;
    }//ok

    private function getTaxonomiesOutFile()
    {

        $data = $this->readExcelFile();

        $cats = [];
            foreach ($data as $row) {
                $cats[] = $row[17].'>'.$row[18]; // Предполагаем, что категория в первой ячейке
            }
        return    array_unique($cats);
    }//ok
//
    private function getProductsOutFile()
    {


            $rows = $this->readExcelFile();
            foreach ($rows as $row) {
                $data[] = [
                    'category' => $row[17].'>'.$row[18],
                    'name' => $row[1],
                    'd1' => $row[2]->getValue(),
                    'd2' => $row[3]->getValue(),
                    'b1' => $row[4]->getValue(),
                    't' => $row[5]->getValue(),
                    'b7' => $row[6]->getValue(),
                    'h' => $row[7]->getValue(),
                    's' => $row[8]->getValue(),
                    'q' => $row[9]->getValue(),
                    'a' => $row[10]->getValue(),
                ];
            }
        return $data;
    }//ok
//
    private function updateTaxonomies()
    {
        echo '<pre>';
        $categories = $this->getTaxonomiesOutFile();
        $cats = $this->getCurrentCategories();
        var_dump($cats);

        foreach ($categories as $cat) {
            $this->processCategory($cat, $cats);
        }
        return $cats;
    }
//
    private function getCurrentCategories()
    {
        $cats = [];
        foreach (get_terms($this->taxonomy, ['hide_empty' => false]) as $term) {
            $cats[] = array_merge($this->getCurrentCatInfo($term->term_id), ['id' => $term->term_id, 'name' => $term->name]);
        }
        return $cats;
    }
//
    private function processCategory($cat, &$cats)
    {
        $cats_explode = explode('>', $cat);
        $search_cat = '';
        $parent = null;

        foreach ($cats_explode as $key => $cex) {
            $search_cat .= '>' . $cex;
            $search_cat = trim($search_cat, '>');
            $exists = false;

            foreach ($cats as $cat_item) {
                if ($cat_item['name'] == $cex && ($key + 1) == $cat_item['lvl'] && $search_cat == $cat_item['string']) {
                    $exists = true;
                    $parent = $cat_item['id'];
                }
            }

            if (!$exists && !empty($cex)) {
                $data = wp_insert_term($cex, $this->taxonomy, [
                    'parent' => $parent ? $parent : 0,
                ]);

                if (!is_wp_error($data)) {
                    $parent = $data['term_id'];
                    $cats[] = [
                        'id' => $data['term_id'],
                        'name' => $cex,
                        'slug' => sanitize_title($cex),
                        'string' => $search_cat,
                        'lvl' => $key + 1,
                    ];
                }
            }
        }
    }
//
    private function searchProducts($name, $cats)
    {
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'product',
            'post_status' => 'publish',
            's' => $name,
            'meta_query' => [
                [
                    'key' => 'product_cat',
                    'value' => $cats, // Здесь вы должны передать категории, которые вы ищете
                    'compare' => 'IN'
                ]
            ]
        ];

        $products = new WP_Query($args);

        if ($products->have_posts()) {
            return $products->posts; // Возвращаем все найденные продукты
        }

        return null;
    }
//
    private function updateProducts($cats)
    {
        $products = $this->getProductsOutFile();

        foreach ($products as $product) {
            // Ищем продукт по имени и категориям
            $post = $this->searchProducts($product['name'], $cats);

            // Если продукт не найден, создаем новый
            if (empty($post)) {
                $post = $this->createNewProduct($product);
            } else {
                $post = $post[0]; // Если нашли, берем первый продукт
            }

            // Обновляем поля продукта
            $this->updateProductFields($post->ID, $product);

            // Удаляем все текущие категории
            wp_delete_object_term_relationships($post->ID, 'product_cat');

            // Устанавливаем категории для продукта
            $this->setProductCategories($post->ID, $product['category'], $cats);
        }
    }
//
    private function createNewProduct($product)
    {
        $new_post_info = [
            'post_title' => $product['name'],
            'post_status' => 'publish',
            'post_type' => 'product',
            'post_author' => get_current_user_id(),
        ];

        // Вставляем новый пост и получаем его ID
        $post_id = wp_insert_post($new_post_info, true);

        // Проверяем, была ли ошибка при создании поста
        if (is_wp_error($post_id)) {
            return null; // Или обработайте ошибку по своему усмотрению
        }

        // Возвращаем объект записи
        return get_post($post_id);
    }//ok
//
    private function updateProductFields($postID, $product)
    {
        update_field('product-d1', $product['d1'], $postID);
        update_field('product-d2', $product['d2'], $postID);
        update_field('product-b1', $product['b1'], $postID);
        update_field('product-t', $product['t'], $postID);
        update_field('product-b7', $product['b7'], $postID);
        update_field('product-h', $product['h'], $postID);
        update_field('product-s', $product['s'], $postID);
        update_field('product-q', $product['q'], $postID);
        update_field('product-a', $product['a'], $postID);
    }//ok
//
    private function setProductCategories($postID, $category, $cats)
    {
        $categoryNames = explode('>', $category);
        $search_cat = '';
        $_category_ids = [];

        foreach ($categoryNames as $key => $name) {
            $search_cat = trim($search_cat . '>' . $name, '>');

            // Используем array_filter для поиска категорий
            $matchingCats = array_filter($cats, function($cat) use ($key, $name, $search_cat) {
                return $cat['lvl'] === $key + 1 && $cat['name'] === $name && $search_cat === $cat['string'];
            });

            // Добавляем найденные категории в массив ID
            foreach ($matchingCats as $cat) {
                $_category_ids[] = $cat['id'];
            }
        }

        // Устанавливаем категории для поста только если есть найденные категории
        if (!empty($_category_ids)) {
            // Используем wp_set_post_terms для установки категорий
            wp_set_post_terms($postID, $_category_ids, 'product_cat', true);
        }
    }
//
    private function getCurrentCatInfo($id, $result = ['string' => '', 'lvl' => 1])
    {
        $tax = get_term($id);
        $result['string'] = $tax->name . '>' . $result['string'];
        if ($tax->parent != 0) {
            $result['lvl']++;
            return $this->getCurrentCatInfo($tax->parent, $result);
        } else {
            $result['string'] = trim($result['string'], '>');
            return $result;
        }
    }//ok
}

new TableImporter();
