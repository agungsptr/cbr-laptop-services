<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Fitur;

class DetailKasus extends Model
{
    protected $table = 'detail_kasus';

    public function Fitur()
    {
       return Fitur::where('id', $this->fitur_id)->first();
    }
}
