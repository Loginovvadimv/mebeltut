<?php

namespace App\Services;

use WP_REST_Request;

class WP_Vk
{

    private static $cleint_id = 52943921;

    static private $groupe_id = -66278755;
    private static $access_token_client = 'vk1.a.tovt3Cxv5HunMb20fXi10psEam4_b1KdIT1D-C4yBmYKwX_u0X_E2cIrOLGaSoOVkBzooN6PNLNFpSJmLZWyfbek9dUdFb7-mOrnr-HfNZNYjgfSbGaWJwH8mIwgVBrRCkkDFlMHAzFyE1FY_nOy0hgh6l9FGIcQjXwJgH7-8gno3ciqs1img9qIxJ9YcEqbL_Fe2htOnK59id0NrSTUqw';
    private static $access_token = 'vk1.a.34icgpQctcTqjlKAm_iXzlbP3RuPRvj4MUBt9hmXGg3cs4tYVvRlMqqBp7J2dJ-L_NaGWAe7peznrn-DPRHIRE6AhbRICsKD149gJbKL19y4_0oRPkrx0TfqOytW4VlXA4kQfOHzDmuLKOvFpqZ_rfTzC9bi5Py84VQBOkqSLedAE_VLeZzGZCoYekBRWS3xRoVMKgRLizNFJg3N5pVwBQ';
    private $countRequest = 0;
    private $time = null;
    private static $v = '5.199';

    private static function vk_request($parameters, $method, $token = null)
    {
        $url = "https://api.vk.com/method/$method";
        $parameters = array_merge($parameters, array(
            'v' => self::$v,

        ));

        if ($token === null) {
            $parameters['access_token'] = self::$access_token_client;
        } else {
            $parameters['access_token'] = $token;
        }
        if (isset($parameters['file'])) {
            $parameters['file'] = new \CURLFile($parameters['file']);
            $url = $method;
        }

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.4) Gecko/2008102920 AdCentriaIM/1.7 Firefox/3.0.4',
            CURLOPT_AUTOREFERER => true,
            CURLOPT_HEADER => false,
            CURLOPT_POST => true, // это именно POST запрос!
            CURLOPT_RETURNTRANSFER => true, // вернуть ответ ВК в переменную
            CURLOPT_SSL_VERIFYPEER => false, // не проверять https сертификаты
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_POSTFIELDS => $parameters,
            CURLOPT_URL => $url
        ));
        $result = json_decode(curl_exec($ch), true);
        $info = curl_getinfo($ch);
        curl_close($ch);
        usleep(350000);


        return $result['response'] ?? $result;
    }

    public function createPost(WP_REST_Request $request)
    {
        $post_id = $request->get_param('post_id');
        //echo var_dump($post_id);
        $text = $content = get_the_content(null, false, $post_id);
        $thumbnail_id = get_post_thumbnail_id($post_id); // Получаем ID миниатюры
        //$image_url = get_attached_file($thumbnail_id); // Получаем URL изображения
        $image_url = get_the_post_thumbnail_url($post_id, 'full');
        //var_dump($image_url);
        //
        //die();
        //$url=self::vk_request([],'photos.getWallUploadServer');
        //var_dump($url);
        //$url = $url['upload_url'];
        //$data_file =self::vk_request([
        //    'file'=>$image_url,
        //],$url);
        //$data=self::vk_request($data_file,'photos.saveWallPhoto');
        //$image_data_id=$data[0]['id'];
        $data = self::vk_request([
            'owner_id' => self::$groupe_id,
            'message' => $text,
            //'link_photo_id'=> self::$groupe_id."_".$image_data_idб
            'attachments' => $image_url
        ], 'wall.post', self::$access_token);
        if (isset($data['post_id']) && $data['post_id'] > 0) {
            return ['success' => true];

        }
        //self::vk_request([
        //    'client_id'=>self::$cleint_id,
        //    'group_ids'=>self::$groupe_id,
        //    'redirect_uri' => 'https://demo4.vyatka-it.ru/vk_autch.php',
        //    'v' => self::$v,
        //    'response_type' => 'token',
        //    'scope' => 'offline,market,photos,groups,wall',
        //    'display' => 'page',
        //], 'groups.get');
    }

    public static function getVKReviews()
    {
        $file = ABSPATH . 'vk/vk_reviews.json';
        $params = [
            'group_id' => -self::$groupe_id,
            'access_token' => self::$access_token,
            'topic_id' => 32798966,
            'sort' => 'desc',
            'count' => 99,
            'extended' => 1,
            'lang' => 0,
        ];
        if (self::isFileNewerThanOneDayOrNotExists($file)) {
            $data = self::vk_request($params, 'board.getComments');
            file_put_contents($file, json_encode($data));
            return self::getReviewData($data);
        } else {
            $data = json_decode(file_get_contents($file), true);

            return self::getReviewData($data);
        }
    }


    static function getReviewData($data)
    {
        $comments = [];


        $profiles = [];

        foreach ($data['profiles'] as $item) {
            $profiles[$item['id']] = $item;
        }

        foreach ($data['items'] as $item) {
            $tmp = [];
            if ($item['from_id'] > 0 && $item['from_id'] != 21612384) {

                $tmp['img'] = $profiles[$item['from_id']]['photo_50'];
                $tmp['name'] = $profiles[$item['from_id']]['first_name'] . ' ' . $profiles[$item['from_id']]['last_name'];
                $tmp['descr'] = $item['text'];
                $tmp['time'] = date("Y-m-d H:i:s", $item['date']);
                $photos = [];
                if (isset($item['attachments'])) {

                    foreach ($item['attachments'] as $attachment) {
                        if ($attachment['type'] == 'photo') {

                            $sizes = [];
                            foreach ($attachment['photo']['sizes'] as $size) {
                                if ($size['type'] == 'x') {
                                    $sizes['m'] = $size['url'];
                                }
                                if ($size['type'] == 'z') {
                                    $sizes['z'] = $size['url'];
                                }
                            }
                            $photos[] = $sizes;
                        }
                    }
                }
                $tmp['photos'] = $photos;
                $comments[] = $tmp;

            }


        }

        return $comments;
    }

    public static function isFileNewerThanOneDayOrNotExists(string $filePath): bool
    {
        // Если файла нет — сразу возвращаем true
        if (!file_exists($filePath)) {
            return true;
        }

        // Получаем время создания файла (в Unix timestamp)
        $fileCreationTime = filemtime($filePath);
        // Текущее время (Unix timestamp)
        $currentTime = time();
        // Разница в секундах (1 день = 86400 секунд)
        $timeDifference = $currentTime - $fileCreationTime;

        // Если файл создан менее чем 24 часа назад — true, иначе false
        return ($timeDifference > 86400);
    }

}


