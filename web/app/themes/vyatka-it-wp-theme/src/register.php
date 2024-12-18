<?php

// Продукция
add_action('init', function () {
    register_post_type('product', array(

        'label'  => 'Продукция',

        'labels' => array(
            'name'               => 'Продукция', // основное название для типа записи
            'singular_name'      => 'Продукция', // название для одной записи этого типа
            'add_new'            => 'Добавить Продукцию', // для добавления новой записи
            'add_new_item'       => 'Добавление Продукции', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактирование Продукции', // для редактирования типа записи
            'new_item'           => 'Новая Продукция', // текст новой записи
            'view_item'          => 'Смотреть Продукцию', // для просмотра записи этого типа.
            'search_items'       => 'Искать Продукцию', // для поиска по этим типам записи
            'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Продукция', // название меню
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
        'menu_icon'           => 'dashicons-hammer',
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => array('title','editor', 'thumbnail', 'excerpt'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => array('categories-product'),
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,

    ));

    // Категории
    register_taxonomy('categories-product', array( 'product' ), array(
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



// Проекты
add_action('init', function () {
    register_post_type('project', array(

        'label'  => 'Проект',

        'labels' => array(
            'name'               => 'Проект', // основное название для типа записи
            'singular_name'      => 'Проект', // название для одной записи этого типа
            'add_new'            => 'Добавить Проект', // для добавления новой записи
            'add_new_item'       => 'Добавление Проекта', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактирование Проекта', // для редактирования типа записи
            'new_item'           => 'Новый Проект', // текст новой записи
            'view_item'          => 'Смотреть Проект', // для просмотра записи этого типа.
            'search_items'       => 'Искать Проект', // для поиска по этим типам записи
            'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Проект', // название меню
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
        'menu_icon'           => 'dashicons-images-alt',
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => array('title','editor', 'thumbnail', 'excerpt'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => array('categories-project'),
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,

    ));

    // Категории
    register_taxonomy('categories-project', array( 'project' ), array(
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




// Особенности
add_action('init', function () {
    register_post_type('feature', array(

        'label'  => 'Особенности',

        'labels' => array(
            'name'               => 'Особенности', // основное название для типа записи
            'singular_name'      => 'Особенности', // название для одной записи этого типа
            'add_new'            => 'Добавить Особенности', // для добавления новой записи
            'add_new_item'       => 'Добавление Особенности', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактирование Особенности', // для редактирования типа записи
            'new_item'           => 'Новый Особенности', // текст новой записи
            'view_item'          => 'Смотреть Особенности', // для просмотра записи этого типа.
            'search_items'       => 'Искать Особенности', // для поиска по этим типам записи
            'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Особенности', // название меню
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
        'menu_icon'           => 'dashicons-images-alt2',
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => array('title','editor', 'thumbnail', 'excerpt'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => array('categories-feature'),
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,

    ));

    // Категории
    register_taxonomy('categories-feature', array( 'feature' ), array(
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
