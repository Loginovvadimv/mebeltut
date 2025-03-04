<?php

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'    => 'Контактные данные',
        'menu_title'    => 'Контактные данные',
        'menu_slug'     => 'contacts-settings',
        'capability'    => 'edit_posts',
        'position'      => 23,
        'icon_url'      => 'dashicons-phone',
        'redirect'      => false
    ));

    acf_add_local_field_group(array(
        'key' => 'contacts-page',
        'title' => 'Контактные данные',
        'fields' => array (
            array (
                'key' => 'phone',
                'label' => 'Телефон',
                'name' => 'Телефон',
                'type' => 'text',
            ),
            array (
                'key' => 'phone2',
                'label' => 'Консультация',
                'name' => 'Консультация',
                'type' => 'text',
            ),
            array (
                'key' => 'email',
                'label' => 'E-Mail',
                'name' => 'E-Mail',
                'type' => 'text',
            ),
            array (
                'key' => 'vk',
                'label' => 'ВКонтакте',
                'name' => 'ВКонтакте',
                'type' => 'text',
            ),
            array (
                'key' => 'address',
                'label' => 'Адрес',
                'name' => 'Адрес',
                'type' => 'text',
            ),
            array (
                'key' => 'tg',
                'label' => 'Telegram',
                'name' => 'Telegram',
                'type' => 'text',
            ),
            array (
                'key' => 'wa',
                'label' => 'Whastapp',
                'name' => 'Whastapp',
                'type' => 'text',
            ),
            array (
                'key' => 'requisits',
                'label' => 'Реквизиты',
                'name' => 'requisits',
                'type' => 'file',
            ),
            array (
                'key' => 'header_code',
                'label' => 'Код в head',
                'name' => 'Код в head',
                'type' => 'textarea',
            ),
            array (
                'key' => 'footer_code',
                'label' => 'Код в footer',
                'name' => 'Код в footer',
                'type' => 'textarea',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'contacts-settings',
                ),
            ),
        ),
    ));

    acf_add_options_page(array(
        'page_title'    => 'Контент',
        'menu_title'    => 'Контент',
        'menu_slug'     => 'content-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Секция "наша Группа ВКонтакте"',
        'menu_title'    => 'Секция "наша Группа ВКонтакте"',
        'parent_slug'   => 'content-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'    => 'Секция "Отзывы"',
        'menu_title'    => 'Секция "Отзывы"',
        'parent_slug'   => 'content-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'    => 'Модальное окно расчета стоимости общее"',
        'menu_title'    => 'Модальное окно расчета стоимости общее"',
        'parent_slug'   => 'content-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'    => 'Как заказать',
        'menu_title'    => 'Как заказать',
        'parent_slug'   => 'content-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'    => 'Как строится работа с нами',
        'menu_title'    => 'Как строится работа с нами',
        'parent_slug'   => 'content-settings',
    ));
}
