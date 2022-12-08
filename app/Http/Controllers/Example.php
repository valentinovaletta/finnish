<?php

namespace App\Http\Controllers;

use App\Lib\CreateImage\CreateImage;
use App\Lib\CreateImage\VK;

class Example extends Controller{

    public function index(){
        $newCambridgeWord = NEW CreateImage();
        //print_r($newCambridgeWord->show());
        $newCambridgeWord->createImage();
        $newCambridgeWord->saveNewWordInDb();
    }

    public function vk(){

        $token = "vk1.a.CkSpYnY7gNEBVKDfvfyyAWQGA3k6r8tzr7RFEHq4pWj5OLg7L1_9MmblaZxnGhEk0YXc-Ak7gn_7pR3fnQs7Ke3CnKyu6vqkBKV3Ku9KadsWrgBmr76j_7YgQdwQYlW99QypylCQ4-9HrIpeBX_24riP6pqRmbdc7EKLpjw0RcIUFbWuo2xRiCY_wLRVVQuQK6q39XqMfBUBu5FF-8yPvg";
        $group_id = '212716589';
        $vk = new Vk($token);
        
        $image_path = 'image.png';
        copy('https://www.google.ru/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png', 'image.png');
        
        $upload_server = $vk->photosGetWallUploadServer($group_id);
        var_dump($upload_server);
        $upload = $vk->uploadFile($upload_server['upload_url'], $image_path);
        var_dump($upload);
        $save = $vk->photosSaveWallPhoto([
                'group_id' => $group_id,
                'photo' => $upload['photo'],
                'server' => $upload['server'],
                'hash' => $upload['hash']
            ]
        );
        var_dump($save);
        $attachments = sprintf('photo%s_%s', $save[0]['owner_id'], $save[0]['id']);
        
        
        $post = $vk->wallPost([
            'owner_id' => "-$group_id",
            'from_group' => 1,
            'message' => "блаблабла",
            'attachments' => $attachments
        ]);
        var_dump($post);
    }

}