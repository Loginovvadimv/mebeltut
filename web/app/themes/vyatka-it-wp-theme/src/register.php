<?php

// Project
add_action('init', function () {

    # Типы записей
    register_post_type('project', array(

        'label' => 'Каталог',

        'labels' => array(
            'name' => 'Проект', // основное название для типа записи
            'singular_name' => 'Проект', // название для одной записи этого типа
            'add_new' => 'Добавить проект', // для добавления новой записи
            'add_new_item' => 'Добавление проекта', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item' => 'Редактирование проекта', // для редактирования типа записи
            'new_item' => 'Новый объект', // текст новой записи
            'view_item' => 'Смотреть объект', // для просмотра записи этого типа.
            'search_items' => 'Искать объект', // для поиска по этим типам записи
            'not_found' => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
            'parent_item_colon' => '', // для родителей (у древовидных типов)
            'menu_name' => 'Каталог', // название меню
        ),

        'description' => '',
        'public' => true,
        'publicly_queryable' => null, // зависит от public
        'exclude_from_search' => null, // зависит от public
        'show_ui' => null, // зависит от public
        'show_in_menu' => null, // показывать ли в меню адмнки
        'show_in_admin_bar' => null, // по умолчанию значение show_in_menu
        'show_in_nav_menus' => null, // зависит от public
        'show_in_rest' => null, // добавить в REST API. C WP 4.7
        'rest_base' => null, // $post_type. C WP 4.7
        'menu_position' => null,
        'menu_icon' => 'dashicons-heart',
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical' => false,
        'supports' => array('title', 'editor', 'thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies' => array('categories-project'),
        'has_archive' => false,
        'rewrite' => true,
        'query_var' => true,

    ));

    register_taxonomy('categories-projects', array( 'project' ), array(
        'hierarchical' => true,
        'labels' => array(
            'name' => 'Категории',
            'singular_name' => 'Категории',
            'search_items' => 'Искать категорию',
            'all_items' => 'Все категории',
            'parent_item' => 'Parent Genre',
            'parent_item_colon' => 'Parent Genre:',
            'edit_item' => 'Изменить категорию',
            'update_item' => 'Update Genre',
            'add_new_item' => 'Добавить категорию',
            'new_item_name' => 'Новая категория',
            'menu_name' => 'Категории',
        ),
        'show_ui' => true,
        'query_var' => true,
        // 'rewrite' => array ('slug' => 'categories', 'with_front' => false),
    ));
});

// Work
add_action('init', function () {
    register_post_type('work', array(

        'label' => 'Портфолио',

        'labels' => array(
            'name' => 'Объект', // основное название для типа записи
            'singular_name' => 'Объект', // название для одной записи этого типа
            'add_new' => 'Добавить объект', // для добавления новой записи
            'add_new_item' => 'Добавление объекта', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item' => 'Редактирование объект', // для редактирования типа записи
            'new_item' => 'Новый объект', // текст новой записи
            'view_item' => 'Смотреть объект', // для просмотра записи этого типа.
            'search_items' => 'Искать объект', // для поиска по этим типам записи
            'not_found' => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
            'parent_item_colon' => '', // для родителей (у древовидных типов)
            'menu_name' => 'Портфолио', // название меню
        ),

        'description' => '',
        'public' => true,
        'publicly_queryable' => null, // зависит от public
        'exclude_from_search' => null, // зависит от public
        'show_ui' => null, // зависит от public
        'show_in_menu' => null, // показывать ли в меню адмнки
        'show_in_admin_bar' => null, // по умолчанию значение show_in_menu
        'show_in_nav_menus' => null, // зависит от public
        'show_in_rest' => null, // добавить в REST API. C WP 4.7
        'rest_base' => null, // $post_type. C WP 4.7
        'menu_position' => null,
        'menu_icon' => 'dashicons-heart',
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical' => false,
        'supports' => array('title', 'editor', 'thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies' => array('categories'),
        'has_archive' => false,
        'rewrite' => true,
        'query_var' => true,

    ));
});

// Article
add_action('init', function () {
    register_post_type('article', array(

        'label'  => 'Блог',

        'labels' => array(
            'name'               => 'Статья', // основное название для типа записи
            'singular_name'      => 'Статья', // название для одной записи этого типа
            'add_new'            => 'Добавить статью', // для добавления новой записи
            'add_new_item'       => 'Добавление статьи', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактирование статьи', // для редактирования типа записи
            'new_item'           => 'Новая статья', // текст новой записи
            'view_item'          => 'Смотреть статью', // для просмотра записи этого типа.
            'search_items'       => 'Искать статью', // для поиска по этим типам записи
            'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Блог', // название меню
        ),

        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => null, // зависит от public
        'exclude_from_search' => null, // зависит от public
        'show_ui'             => null, // зависит от public
        'show_in_menu'        => null, // показывать ли в меню адмнки
        'show_in_admin_bar'   => null, // по умолчанию значение show_in_menu
        'show_in_nav_menus'   => null, // зависит от public
        'show_in_rest'        => true, // добавить в REST API. C WP 4.7
        'rest_base'           => null, // $post_type. C WP 4.7
        'menu_position'       => null,
        'menu_icon'           => 'dashicons-heart',
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => array('title','editor', 'thumbnail', 'excerpt'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => array('categories-blog'),
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,

    ));

    // Категории
    register_taxonomy('categories-blog', array( 'article' ), array(
        'hierarchical' => true,
        'labels' => array(
            'name' => 'Категории',
            'singular_name' => 'Категории',
            'search_items' => 'Искать категорию',
            'all_items' => 'Все категории',
            'parent_item' => 'Parent Genre',
            'parent_item_colon' => 'Parent Genre:',
            'edit_item' => 'Изменить категорию',
            'update_item' => 'Update Genre',
            'add_new_item' => 'Добавить категорию',
            'new_item_name' => 'Новая категория',
            'menu_name' => 'Категории',
        ),
        'show_ui' => true,
        'query_var' => true,
        'show_in_rest' => true,
        // 'rewrite' => array ('slug' => 'categories', 'with_front' => false),
    ));
});
