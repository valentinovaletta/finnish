<?php

namespace App\Http\Controllers;

use App\Lib\CreateImage\CreateImage;
use App\Lib\CreateImage\VK;

use App\Lib\Newwords\CambridgeParserLibrary;

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
        $text = "Наш телегам бот для заучивания новых слов\r\nhttps://t.me/New9wordsBot \r\n\r\nНовые слова\r\n";
        $imgs = [];
        $vk = new Vk($token);
        $images = NEW CreateImage();

        $imagesInfo = $images->getImageInfo(9);

        foreach($imagesInfo as $img){
            $text .= $img->word." [".$img->ts."]\r\n";
            $imgs[] = "https://enru.arcadepub.ru/images/$img->word.jpg";
        }

        $text .= "#Английский #English #АнглийскиеСлова #EnglishWords #НовыеАнглийскиеСлова";

        $upload_server = $vk->photosGetWallUploadServer($group_id);
        print_r($imgs);

        foreach($imgs as $img){
            $uploads[$i++] = $vk->uploadFile($upload_server['upload_url'], $img);
        }
        //print_r($uploads);

        foreach($uploads as $upload){
            $saves[$j++] = $vk->photosSaveWallPhoto([
                'group_id' => $group_id,
                'photo' => $upload['photo'],
                'server' => $upload['server'],
                'hash' => $upload['hash']
            ]);        
        }
        //print_r($saves);

        foreach($saves as $key=>$save){
            $attachments .= 'photo'.$save[0]['owner_id'].'_'.$save[0]['id'].',';
        }
        //print_r($attachments);

        $post = $vk->wallPost([
            'owner_id' => "-$group_id",
            'from_group' => 1,
            'message' => $text,
            'attachments' => $attachments
        ]);

    }

    public function Inst() {
    
        $newCambridgeWord = NEW CambridgeParserLibrary();
        $word = $newCambridgeWord->getNewWord();
        $def = $newCambridgeWord->getDefinition( trim($word) );
        $ex = $newCambridgeWord->getExample( trim($word) );

        dd($word,$def,$ex);

    }

}