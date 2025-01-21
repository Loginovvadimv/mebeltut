<?php

function  generate_token_url(){
    $url = 'https://oauth.vk.com/authorize?';
    $param = array(
        'client_id' => 52943921,
            'redirect_uri' => 'https://demo4.vyatka-it.ru/vk_autch.php',
        'display' => 'page',
        'group_ids' => 66278755,
        'scope' => 'photos , wall',
        'response_type' => 'token',
        'v' => 5.199
    );
    echo '<a href="' . $url . http_build_query($param) . '">Доступ</a>';
}

generate_token_url();
