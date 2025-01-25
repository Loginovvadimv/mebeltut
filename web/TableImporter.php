<?php
class TableImporter
{

    private $file = 'test.csv';
    private $delimiter = ';';
    private $data = null;
    private $taxonomy = 'categories-product';
    private $type = 'product';

    public function __construct()
    {
        $this->updateChainsHook();
    }

    public function updateChainsHook()
    {
//        $cats= null;
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
            $data = [];
            foreach ($rows as $row) {
                if (empty($data[$row[2]])) {
                    $data[$row[2]]['category'] =$row[17].'>'.$row[18];
                    $data[$row[2]]['name'] = $row[1];
                    $data[$row[2]]['content'] = $row[7];
                    $data[$row[2]]['images'][]='https://meb43.ru'.$row[15];
                    $data[$row[2]]['price']=$row[16];
                }else{
                    $data[$row[2]]['images'][]='https://meb43.ru'.$row[15];
                }
            }
        return $data;
    }//ok
//
    private function updateTaxonomies()
    {
        echo '<pre>';
        $categories = $this->getTaxonomiesOutFile();
        $cats = $this->getCurrentCategories();

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
            'post_type' => $this->type,
            'post_status' => 'publish',
            's' => $name,
            'meta_query' => [
                [
                    'key' => $this->taxonomy,
                    'value' => $cats, // Здесь вы должны передать категории, которые вы ищете
                    'compare' => 'IN'
                ]
            ]
        ];
//        var_dump($args);

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
            $thumb = array_shift($product['images']); // Генерируем превью для product

            $this->generate_featured_image($thumb, $post->ID,true);


            // Обновляем поля продукта
            $this->updateProductFields($post->ID, $product);

            // Удаляем все текущие категории
            wp_delete_object_term_relationships($post->ID,  $this->taxonomy);

            // Устанавливаем категории для продукта
            $this->setProductCategories($post->ID, $product['category'], $cats);
        }
    }
//

    function generate_featured_image( $image_url, $post_id, $is_thumb=false  ){
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image_url);
        $filename = basename($image_url);
        if(wp_mkdir_p($upload_dir['path']))
            $file = $upload_dir['path'] . '/' . $filename;
        else
            $file = $upload_dir['basedir'] . '/' . $filename;
        file_put_contents($file, $image_data);

        $wp_filetype = wp_check_filetype($filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
        if ($is_thumb){
            $res2= set_post_thumbnail( $post_id, $attach_id );
        }
        return $attach_id;
    }

    private function createNewProduct($product)
    {
        $new_post_info = [
            'post_title' => $product['name'],
            'post_status' => 'publish',
            'post_type' => $this->type,
            'post_content' =>$product['content'],

//            'post_author' => get_current_user_id(),
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
    private function updateProductFields($postID, $product){
        $attach_ids=[];
        foreach ($product['images'] as $key => $image) {
            $attach_ids[] = $this->generate_featured_image($image, $postID);
        }
        update_field("product_imgs", $attach_ids, $postID );
        update_field('price', $product['price'], $postID);

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
            wp_set_post_terms($postID, $_category_ids, $this->taxonomy, true);
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
