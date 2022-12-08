<?php

namespace App\Lib\CreateImage;

class VK {

        private $token;
        private $v = '5.37';
    
        public function __construct($token)
        {
            $this->token = $token;
        }
    
        public function wallPost($data)
        {
            return $this->request('wall.post', $data);
        }
    
        public function photosGetWallUploadServer($group_id)
        {
            $params = [
                'group_id' => $group_id,
            ];
            return $this->request('photos.getWallUploadServer', $params);
        }
    
        /**
         * @param $params [user_id, group_id, photo, server, hash]
         * @return mixed
         * @throws \Exception
         */
        public function photosSaveWallPhoto($params)
        {
            return $this->request('photos.saveWallPhoto', $params);
        }
    
        public function uploadFile($url, $path)
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
    
            if (class_exists('\CURLFile')) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, ['file1' => new \CURLFile($path)]);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, ['file1' => "@$path"]);
            }
    
            $data = curl_exec($ch);
            curl_close($ch);
            return json_decode($data, true);
        }
    
        private function request($method, array $params)
        {
            $params['v'] = $this->v;
    
            $ch = curl_init('https://api.vk.com/method/' . $method . '?access_token=' . $this->token);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            $data = curl_exec($ch);
            curl_close($ch);
            $json = json_decode($data, true);
            if (!isset($json['response'])) {
                throw new \Exception($data);
            }
            usleep(mt_rand(1000000, 2000000));
            return $json['response'];
        }
}