<?php

namespace App\Http\Controllers;

use App\Lib\CreateImage\CreateImage;
use App\Lib\CreateImage\VK;

use Instagram\User\Media;
use Instagram\User\MediaPublish;

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
        $i = 0;
        $j = 0;
        $attachments='';
        $text = '';
        $imgs = [];
        $vk = new Vk($token);
        $images = NEW CreateImage();

        $imagesInfo = $images->getImageInfo(9);

        foreach($imagesInfo as $img){
            $text .= $img->word." [".$img->ts."]\r\n";
            $imgs[] = "https://enru.arcadepub.ru/images/$img->word.jpg";
        }
        
        $upload_server = $vk->photosGetWallUploadServer($group_id);

        foreach($imgs as $img){
            $uploads[$i++] = $vk->uploadFile($upload_server['upload_url'], $img);
        }

        foreach($uploads as $upload){
            $saves[$j++] = $vk->photosSaveWallPhoto([
                'group_id' => $group_id,
                'photo' => $upload['photo'],
                'server' => $upload['server'],
                'hash' => $upload['hash']
            ]);        
        }

        foreach($saves as $key=>$save){
            $attachments .= 'photo'.$save[0]['owner_id'].'_'.$save[0]['id'].',';
        }
        
        $post = $vk->wallPost([
            'owner_id' => "-$group_id",
            'from_group' => 1,
            'message' => $text,
            'attachments' => $attachments
        ]);

    }

    public function Inst() {
    
        $config = array( // instantiation config params
            'user_id' => '118960607695447',
            'access_token' => ENV('INST_TOKEN'),
        );
        
        // instantiate user media
        $media = new Media( $config );
        
        $imageContainerParams = array( // container parameters for the image post
            'caption' => 'test', // caption for the post
            'image_url' => 'https://www.howtogeek.com/wp-content/uploads/2009/11/5bsod.png?height=200p&trim=2,2,2,2', // url to the image must be on a public server
        );
        
        // create image container
        $imageContainer = $media->create( $imageContainerParams );
        
        // get id of the image container
        $imageContainerId = $imageContainer['id'];
        
        // instantiate media publish
        $mediaPublish = new MediaPublish( $config );
        
        // post our container with its contents to instagram
        $publishedPost = $mediaPublish->create( $imageContainerId );
        
        print_r($publishedPost);
    }

}