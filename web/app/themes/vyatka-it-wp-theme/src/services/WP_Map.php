<?php

namespace App\Services;

use Timber;
use WP_REST_Request;

class WP_Map
{
    public function get_elements(WP_REST_Request $request): array
    {
        $id = $request->get_param('el_id');

        $post = Timber::get_post($id);

        return [
            'id' => $post->ID,
            'name' => $post->post_title,
            'image' => $post->thumbnail()->guid,
            'href' => $post->link(),
            'params' => $post->parameters,
        ];
    }
}
