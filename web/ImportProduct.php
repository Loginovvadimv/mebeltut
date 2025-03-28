<?php
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
ini_set('memory_limit', '1048M');

class ImportProduct
{


    public function __construct()
    {


        $projects = Timber::get_posts([
            'post_type' => 'project',
            'posts_per_page' => 100,
            'offset' => 0
        ]);


        $categories_products = $this->getAllCategory();
        foreach ($projects as $project) {
            // Получаем мета-поле 'project_photos' для каждого поста

            $post_data = array(
                'post_title' => $project->post_title,
                'post_content' => $project->post_content,
                'post_status' => 'publish', // Статус поста: 'publish', 'draft' и т.д.
                'post_type' => 'product',    // Тип записи: 'post', 'page' или кастомный тип
            );
            echo 'project id' . $project->ID . PHP_EOL;
            $post_id = wp_insert_post($post_data);
            echo 'product id' . $post_id . PHP_EOL;
            if ($post_id) {
                $categories = $project->terms('categories-project');
                foreach ($categories as $category) {
                    $taxonomy = 'categories-product'; // Replace with your custom taxonomy name
                    // Define the custom taxonomy and term
                    $term = $categories_products[$category->name]; // Replace with the slug of the term you want to assign
                    wp_set_object_terms($post_id, $term, $taxonomy);
                }
                echo "Post created successfully with ID: " . $post_id;
            } else {
                echo "Failed to create post.";
            }

            $images[] = $project->thumbnail->src('full');
            $project_photos = $project->meta('project_photos');


            foreach (array_column($project_photos, 'photo') as $value) {
                $images[] = $value;
            }


            $imgs = $this->setAttachment($images);

            if ($imgs['thumbnail']) {
                set_post_thumbnail($post_id, $imgs['thumbnail']);
            }
            if ($imgs['gallery']) {
                update_post_meta($post_id, 'product_imgs', $imgs['gallery']);
            }
        }

    }

    function getAllCategory()
    {

        $terms = Timber::get_terms([
            'taxonomy' => 'categories-product',
            'hide_empty' => false, // Set to true if you only want terms with posts
        ]);


        $categories_project = [];
        foreach ($terms as $term) {
            $categories_project[$term->name] = $term->ID;
        }
        return $categories_project;
    }

    function createCategory()
    {
        $terms = Timber::get_terms([
            'taxonomy' => 'categories-project',
            'hide_empty' => false, // Set to true if you only want terms with posts
        ]);
        $categories_project = [];

        foreach ($terms as $term) {
            $category = get_term_by('name', $term->name, 'categories-product');
            if ($category) {
                $categories_project[$term->name] = $category->term_id;
            } else {

                $result = wp_insert_term(
                    $term->name, // Название категории
                    'categories-product',  // Таксономия WooCommerce для категорий товаров
                    array(
//                        'slug'        => $categcategories-productory_slug, // Слаг категории
//                        'description' => 'Описание категории', // Описание категории (опционально)
                        'parent' => 0, // ID родительской категории (0 для корневой категории)
                    )
                );
                $categories_project[$term->name] = $result['term_id'];

            }
        }

        return $categories_project;
    }


    private function check_image_exists_by_name($image_name)
    {
        // Получаем загрузки WordPress
//        $upload_dir = wp_upload_dir();
//        $image_url = $upload_dir['url'] . '/' . $image_name;
        // Проверяем, существует ли изображение
        $attachment_id = attachment_url_to_postid($image_name);

        if ($attachment_id) {
            return $attachment_id; // Изображение существует
        }

        return false; // Изображение не найдено
    }

    function setAttachment($arr_url)
    {
        $attachment_ids = [];
        foreach ($arr_url as $image_url) {
            $image_id = $this->saveImageByUrl($image_url);
            if ($image_id) {
                $attachment_ids[] = $image_id;
            }
        }
        if (count($attachment_ids) > 0) {
            return [
                'thumbnail' => array_shift($attachment_ids),
                'gallery' => $attachment_ids
            ];
        } else {
            return [
                'thumbnail' => null,
                'gallery' => null
            ];
        }


    }

    public function saveImageByUrl(string $image_url)
    {
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attachment = $this->check_image_exists_by_name($image_url);
        if ($attachment) {
            return $attachment;
        }
        $attachment_id = media_sideload_image($image_url, 0, basename($image_url), 'id');
        if (is_wp_error($attachment_id)) {
            echo $attachment_id->get_error_message();
            exit;
        }
        return $attachment_id;
    }
}
