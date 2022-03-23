<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IT extends Model
{
    protected $table = "itjob";
    protected $guarded = ['id'];

    public function unit(){
      return $this->belongsTo('App\Unit','id_unit');
    }
}
