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

        $token = "vk1.a.SK_FTVNVE_hYo3NZbS_Q28pdU2E88rZqfW-bpjYUnYckdxaqyspZ8-u3SgoupyRzcGWIX8LEqw_9K7ix-BPPtdp4D6bfChElzHrG-_cDQOCf0wwk-NA-gitku5T3IBR8KJsJ9Qo2VjMmRhWTvi6BH5K54nWIkwcMCsje1yoAqljT8EoJovVfHrucG2wRK2WU2wGXz-UIxhgAHzyHIInEwg";
        $group_id = '-212716589';
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