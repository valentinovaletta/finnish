<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class Test extends Controller{

    private $id;

    public function index(){

        $this->id = 494963311;

        $data = DB::table($this->id.'_vocabulary')
        ->join('en_dictionaries', $this->id.'_vocabulary.word_id', '=', 'en_dictionaries.id')
        ->join('fi_dictionaries', $this->id.'_vocabulary.word_id', '=', 'fi_dictionaries.id')
        ->select($this->id.'_vocabulary.word_id', $this->id.'_vocabulary.points', 'en_dictionaries.word as enword', 'en_dictionaries.pos as pos', 'en_dictionaries.ts as ts', 'en_dictionaries.img as img', 'fi_dictionaries.word as fiword')
        ->orderBy($this->id.'_vocabulary.points')
        ->take(4)
        ->get()
        ->toArray();

        echo '<table>';
        foreach($data as $row){
            echo "<tr>
                <td>$row->word_id</td>
                <td>".$row->points."</td>
                <td>".$row->enword."</td>
                <td>".$row->pos."</td>
                <td>".$row->ts."</td>
                <td>".$row->fiword."</td>
                <td><img src='".$row->img."'></td>
            </tr>";
        }
        echo '</table>';
    }

}